<!DOCTYPE html>
<html>
<head>
    <title>Daftar Mahasiswa</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 text-primary">📋 Daftar Mahasiswa</h1>
            <div class="d-flex gap-2">
                <a href="{{ route('mahasiswa.export.pdf') }}" class="btn btn-danger btn-sm">
                    📄 Export PDF
                </a>
                <a href="{{ route('mahasiswa.export.excel') }}" class="btn btn-success btn-sm">
                    📊 Export Excel
                </a>
                <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary">
                    + Tambah Mahasiswa
                </a>
            </div>
        </div>

        <!-- Alert Success -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- Search Form -->
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <form action="{{ route('mahasiswa.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama, NIM, atau email..." value="{{ $search ?? '' }}">
                        <button type="submit" class="btn btn-primary">🔍 Cari</button>
                        @if($search)
                        <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">Reset</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-striped table-bordered align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Email</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mahasiswa as $m)
                        <tr>
                            <td>{{ $m->nama }}</td>
                            <td>{{ $m->nim }}</td>
                            <td>{{ $m->email }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('mahasiswa.edit',$m->id) }}" class="btn btn-warning btn-sm">✏ Edit</a>
                                    <form action="{{ route('mahasiswa.destroy',$m->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">🗑 Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($mahasiswa->isEmpty())
                    <p class="text-center text-muted">Belum ada data mahasiswa.</p>
                @endif
            </div>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted">
                Menampilkan {{ $mahasiswa->firstItem() ?? 0 }} - {{ $mahasiswa->lastItem() ?? 0 }} dari {{ $mahasiswa->total() }} data
            </div>
            <div>
                {{ $mahasiswa->links() }}
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>