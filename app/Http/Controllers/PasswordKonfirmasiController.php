<?php

namespace App\Http\Controllers;

use App\Models\PasswordKonfirmasi;
use Illuminate\Http\Request;

class PasswordKonfirmasiController extends Controller
{
    public function store(Request $request)
    {
        if (!in_array(auth()->user->id, [1,2])) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses');
        }

        $data = $request->validate([
            'password' => 'required',
        ]);

        $check = PasswordKonfirmasi::first();

        if ($check) {
            $check->update($data);
            return redirect()->back()->with('success', 'Password berhasil diubah');
        }

        PasswordKonfirmasi::create($data);

        return redirect()->back()->with('success', 'Password berhasil ditambahkan');

    }
}
