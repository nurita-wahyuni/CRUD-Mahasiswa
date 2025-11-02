<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\MahasiswaExport;
use Rap2hpoutre\FastExcel\FastExcel;

class MahasiswaController extends Controller
{
    // READ with Search & Pagination
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $mahasiswa = Mahasiswa::when($search, function($query, $search) {
            return $query->where('nama', 'like', "%{$search}%")
                        ->orWhere('nim', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
        })->paginate(10);
        
        return view('mahasiswa.index', compact('mahasiswa', 'search'));
    }

    // CREATE FORM
    public function create()
    {
        return view('mahasiswa.create');
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:mahasiswas',
            'email' => 'required|email|unique:mahasiswas',
        ]);

        Mahasiswa::create($request->all());
        return redirect()->route('mahasiswa.index')->with('success','Data berhasil ditambahkan!');
    }

    // EDIT FORM
    public function edit(Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    // UPDATE
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required|unique:mahasiswas,nim,'.$mahasiswa->id,
            'email' => 'required|email|unique:mahasiswas,email,'.$mahasiswa->id,
        ]);

        $mahasiswa->update($request->all());
        return redirect()->route('mahasiswa.index')->with('success','Data berhasil diperbarui!');
    }

    // DELETE
    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();
        return redirect()->route('mahasiswa.index')->with('success','Data berhasil dihapus!');
    }

    // EXPORT PDF
    public function exportPdf()
    {
        $mahasiswa = Mahasiswa::all();
        $pdf = Pdf::loadView('mahasiswa.pdf', compact('mahasiswa'));
        return $pdf->download('data-mahasiswa.pdf');
    }

    // EXPORT EXCEL
    public function exportExcel()
    {
        return (new FastExcel(MahasiswaExport::export()))->download('data-mahasiswa.xlsx');
    }
}
