<?php

namespace Tests\Feature;

use App\Enums\StatusKendaraan;
use App\Models\Kendaraan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    private function customerUser(): User
    {
        return User::factory()->customer()->create();
    }

    private function validPayload(Kendaraan $kendaraan, array $overrides = []): array
    {
        return array_merge([
            'kendaraan_id' => $kendaraan->id,
            'tipe_sewa' => 'lepas_kunci',
            'metode_antar' => 'jemput_sendiri',
            'tanggal_mulai' => now()->addDays(3)->format('Y-m-d'),
            'tanggal_selesai' => now()->addDays(5)->format('Y-m-d'),
            'lokasi_jemput' => 'Jl. Merdeka No. 1',
        ], $overrides);
    }

    public function test_customer_can_create_booking(): void
    {
        $user = $this->customerUser();
        $kendaraan = Kendaraan::factory()->tersedia()->create();

        $response = $this->actingAs($user)->post(route('booking.store'), $this->validPayload($kendaraan));

        $response->assertRedirect();
        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id,
            'kendaraan_id' => $kendaraan->id,
            'status' => 'pending',
        ]);
    }

    public function test_booking_rejected_when_kendaraan_not_available(): void
    {
        $user = $this->customerUser();
        $kendaraan = Kendaraan::factory()->disewa()->create();

        $response = $this->actingAs($user)
            ->from(route('booking.create', ['kendaraan_id' => $kendaraan->id]))
            ->post(route('booking.store'), $this->validPayload($kendaraan));

        $response->assertRedirect()
            ->assertSessionHas('error');
        $this->assertDatabaseCount('bookings', 0);
    }

    public function test_booking_rejected_when_dates_overlap_existing_booking(): void
    {
        $user = $this->customerUser();
        $kendaraan = Kendaraan::factory()->tersedia()->create();

        $this->actingAs($user)->post(route('booking.store'), $this->validPayload($kendaraan));

        $response = $this->actingAs($user)
            ->from(route('booking.create', ['kendaraan_id' => $kendaraan->id]))
            ->post(route('booking.store'), $this->validPayload($kendaraan));

        $response->assertRedirect()
            ->assertSessionHas('error');
        $this->assertDatabaseCount('bookings', 1);
    }

    public function test_booking_can_be_created_after_previous_one_cancelled(): void
    {
        $user = $this->customerUser();
        $kendaraan = Kendaraan::factory()->tersedia()->create();

        $booking = \App\Models\Booking::factory()->create([
            'user_id' => $user->id,
            'kendaraan_id' => $kendaraan->id,
            'status' => 'cancelled',
            'tanggal_mulai' => now()->addDays(3),
            'tanggal_selesai' => now()->addDays(5),
        ]);

        $response = $this->actingAs($user)
            ->from(route('booking.create', ['kendaraan_id' => $kendaraan->id]))
            ->post(route('booking.store'), $this->validPayload($kendaraan));

        $response->assertRedirect()
            ->assertSessionHas('success');
        $this->assertDatabaseCount('bookings', 2);
    }

    public function test_guest_cannot_access_booking_routes(): void
    {
        $this->get(route('booking.create'))->assertRedirect(route('login'));
        $this->post(route('booking.store'), [])->assertRedirect(route('login'));
    }

    public function test_customer_cannot_see_others_booking(): void
    {
        $userA = $this->customerUser();
        $userB = $this->customerUser();
        $booking = \App\Models\Booking::factory()->create(['user_id' => $userB->id]);

        $this->actingAs($userA)->get(route('booking.show', $booking))->assertForbidden();
    }

    public function test_admin_cannot_access_customer_booking_routes(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->get(route('booking.create'))->assertForbidden();
    }
}
