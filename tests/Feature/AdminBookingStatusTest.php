<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Pembayaran;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminBookingStatusTest extends TestCase
{
    use RefreshDatabase;

    private function adminUser(): User
    {
        return User::factory()->admin()->create();
    }

    public function test_valid_transition_pending_to_confirmed(): void
    {
        $booking = Booking::factory()->create(['status' => 'pending']);
        Pembayaran::factory()->create([
            'booking_id' => $booking->id,
            'status' => 'lunas',
        ]);

        $response = $this->actingAs($this->adminUser())
            ->put(route('admin.booking.updateStatus', $booking), ['status' => 'confirmed']);

        $response->assertSessionHas('success');
        $this->assertSame('confirmed', $booking->fresh()->status->value);
    }

    public function test_cannot_confirm_without_lunas_payment(): void
    {
        $booking = Booking::factory()->create(['status' => 'pending']);

        $response = $this->actingAs($this->adminUser())
            ->put(route('admin.booking.updateStatus', $booking), ['status' => 'confirmed']);

        $response->assertSessionHas('error');
        $this->assertSame('pending', $booking->fresh()->status->value);
    }

    public function test_invalid_transition_skipping_steps_is_rejected(): void
    {
        $booking = Booking::factory()->create(['status' => 'pending']);
        Pembayaran::factory()->create([
            'booking_id' => $booking->id,
            'status' => 'lunas',
        ]);

        $response = $this->actingAs($this->adminUser())
            ->put(route('admin.booking.updateStatus', $booking), ['status' => 'completed']);

        $response->assertSessionHas('error');
        $this->assertSame('pending', $booking->fresh()->status->value);
    }

    public function test_completed_booking_is_terminal(): void
    {
        $booking = Booking::factory()->completed()->create();

        $response = $this->actingAs($this->adminUser())
            ->put(route('admin.booking.updateStatus', $booking), ['status' => 'cancelled']);

        $response->assertSessionHas('error');
        $this->assertSame('completed', $booking->fresh()->status->value);
    }

    public function test_ongoing_sets_kendaraan_disewa(): void
    {
        $booking = Booking::factory()->confirmed()->create();
        Pembayaran::factory()->create([
            'booking_id' => $booking->id,
            'status' => 'lunas',
        ]);

        $this->actingAs($this->adminUser())
            ->put(route('admin.booking.updateStatus', $booking), ['status' => 'ongoing']);

        $this->assertSame('disewa', $booking->fresh()->kendaraan->status->value);
    }

    public function test_cancelled_returns_kendaraan_to_tersedia(): void
    {
        $booking = Booking::factory()->create(['status' => 'ongoing']);
        $booking->kendaraan->update(['status' => 'disewa']);

        $this->actingAs($this->adminUser())
            ->put(route('admin.booking.updateStatus', $booking), ['status' => 'cancelled']);

        $this->assertSame('tersedia', $booking->fresh()->kendaraan->status->value);
    }

    public function test_customer_cannot_update_booking_status(): void
    {
        $booking = Booking::factory()->create(['status' => 'pending']);
        $customer = User::factory()->customer()->create();

        $this->actingAs($customer)
            ->put(route('admin.booking.updateStatus', $booking), ['status' => 'confirmed'])
            ->assertForbidden();
    }
}