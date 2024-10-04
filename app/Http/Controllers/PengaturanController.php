<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function batasan()
    {
        $data = Pengaturan::all();

        return view('pengaturan.batasan.index', [
            'data' => $data
        ]);
    }

    public function batasan_update(Pengaturan $batasan, Request $request)
    {
        $data = $request->validate([
            'nilai' => 'required'
        ]);

        $data['nilai'] = str_replace('.', '', $data['nilai']);

        $batasan->update($data);

        return redirect()->route('pengaturan.batasan')->with('success', 'Data berhasil diubah!');
    }
}
