<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PembayaranTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_upload_bukti_bayar(): void
    {
        Storage::fake('public');

        $user = User::factory()->customer()->create();
        $booking = Booking::factory()->create([
            'user_id' => $user->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)->post(route('pembayaran.store', $booking), [
            'metode' => 'transfer_manual',
            'bukti_bayar' => UploadedFile::fake()->create('bukti.jpg', 100, 'image/jpeg'),
        ]);

        $response->assertRedirect(route('booking.show', $booking))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('pembayarans', [
            'booking_id' => $booking->id,
            'metode' => 'transfer_manual',
            'jumlah_bayar' => $booking->grand_total,
            'status' => 'menunggu_verifikasi',
        ]);
    }

    public function test_customer_cannot_pay_twice_while_awaiting_verification(): void
    {
        Storage::fake('public');

        $user = User::factory()->customer()->create();
        $booking = Booking::factory()->create([
            'user_id' => $user->id,
            'status' => 'pending',
        ]);

        $this->actingAs($user)->post(route('pembayaran.store', $booking), [
            'metode' => 'transfer_manual',
            'bukti_bayar' => UploadedFile::fake()->create('bukti.jpg', 100, 'image/jpeg'),
        ]);

        $response = $this->actingAs($user)->post(route('pembayaran.store', $booking), [
            'metode' => 'transfer_manual',
            'bukti_bayar' => UploadedFile::fake()->create('bukti2.jpg', 100, 'image/jpeg'),
        ]);

        $response->assertSessionHas('error');
        $this->assertDatabaseCount('pembayarans', 1);
    }

    public function test_customer_can_resubmit_payment_after_rejection(): void
    {
        Storage::fake('public');

        $user = User::factory()->customer()->create();
        $booking = Booking::factory()->create([
            'user_id' => $user->id,
            'status' => 'pending',
        ]);

        $this->actingAs($user)->post(route('pembayaran.store', $booking), [
            'metode' => 'transfer_manual',
            'bukti_bayar' => UploadedFile::fake()->create('bukti.jpg', 100, 'image/jpeg'),
        ]);

        $booking->pembayaran->update(['status' => 'ditolak']);

        $response = $this->actingAs($user)->post(route('pembayaran.store', $booking), [
            'metode' => 'transfer_manual',
            'bukti_bayar' => UploadedFile::fake()->create('bukti2.jpg', 100, 'image/jpeg'),
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseCount('pembayarans', 1);
        $this->assertSame('menunggu_verifikasi', $booking->pembayaran->fresh()->status->value);
    }

    public function test_cannot_pay_for_others_booking(): void
    {
        $userA = User::factory()->customer()->create();
        $userB = User::factory()->customer()->create();
        $booking = Booking::factory()->create(['user_id' => $userB->id]);

        $this->actingAs($userA)->get(route('pembayaran.create', $booking))->assertForbidden();
        $this->actingAs($userA)->post(route('pembayaran.store', $booking), [
            'metode' => 'transfer_manual',
            'bukti_bayar' => UploadedFile::fake()->create('bukti.jpg', 100, 'image/jpeg'),
        ])->assertForbidden();
    }
}