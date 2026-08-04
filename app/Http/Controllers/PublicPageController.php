<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class PublicPageController extends Controller
{
    public function layanan()
    {
        return view('layanan');
    }

    public function kontak()
    {
        return view('kontak');
    }

    public function kontakStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        Contact::create($validated);

        return back()->with('success', 'Pesan Anda berhasil dikirim. Tim kami akan menghubungi Anda segera.');
    }
}
