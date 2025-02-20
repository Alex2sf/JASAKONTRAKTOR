<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center">Daftar Tugas yang Tersedia</h2>
        @if(isset($tasks))
        <p>Data tugas ditemukan: {{ $tasks->count() }} tugas</p>
    @else
        <p>Variabel $tasks tidak tersedia</p>
    @endif

        @if ($tasks->count() > 0)
            <div class="row">
                @foreach ($tasks as $task)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            @if ($task->image)
                                <img src="{{ asset('storage/' . $task->image) }}" class="card-img-top" alt="Gambar Tugas">
                            @else
                                <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Placeholder">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $task->lokasi_proyek }}</h5>
                                <p class="card-text">
                                    <strong>Diposting oleh:</strong> {{ $task->user->name }}<br>
                                    <strong>Estimasi Anggaran:</strong> {{ $task->estimasi_anggaran ? 'Rp ' . number_format($task->estimasi_anggaran, 0, ',', '.') : 'Tidak ada estimasi' }}<br>
                                    <strong>Tanggal Mulai:</strong> {{ $task->tanggal_mulai->format('d M Y') }}<br>
                                    <strong>Durasi:</strong> {{ $task->durasi_proyek ? $task->durasi_proyek . ' hari' : 'Tidak diketahui' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info">
                Belum ada tugas yang diposting.
            </div>
        @endif
    </div>
</body>
</html>
