<?php

namespace App\Exports;

use App\Models\Mahasiswa;

class MahasiswaExport
{
    public static function export()
    {
        return Mahasiswa::select('nama', 'nim', 'email')->get()->map(function($mahasiswa) {
            return [
                'Nama' => $mahasiswa->nama,
                'NIM' => $mahasiswa->nim,
                'Email' => $mahasiswa->email,
            ];
        });
    }
}
