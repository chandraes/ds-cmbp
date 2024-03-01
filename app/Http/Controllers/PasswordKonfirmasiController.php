<?php

namespace App\Http\Controllers;

use App\Models\PasswordKonfirmasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasswordKonfirmasiController extends Controller
{
    public function store(Request $request)
    {
        $id = [1,2];

        if (!in_array(Auth::user()->id, $id)){
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
