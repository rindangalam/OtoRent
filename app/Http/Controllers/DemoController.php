<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DemoController extends Controller
{
    public function index()
    {
        if (! \App\Providers\DemoServiceProvider::isDemoMode()) {
            throw new NotFoundHttpException();
        }

        return view('demo.menu');
    }

    public function login(Request $request, string $role)
    {
        if (! \App\Providers\DemoServiceProvider::isDemoMode()) {
            throw new NotFoundHttpException();
        }

        $email = match ($role) {
            'admin' => 'admin@otorent.com',
            'staff' => 'staff@otorent.com',
            'customer' => 'andi@example.com',
            default => null,
        };

        if (! $email) {
            abort(404);
        }

        $user = User::where('email', $email)->first();

        if (! $user) {
            abort(404, 'Akun demo belum tersedia. Jalankan migrasi & seeder terlebih dahulu.');
        }

        Auth::login($user);
        $request->session()->regenerate();

        return $user->role->value === 'customer'
            ? redirect()->route('customer.dashboard')
            : redirect()->route('dashboard');
    }
}
