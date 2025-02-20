<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posting Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h4>Posting Tugas</h4>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('user.task.post') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="lokasi_proyek">Lokasi Proyek</label>
                        <input type="text" name="lokasi_proyek" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="estimasi_anggaran">Estimasi Anggaran (Opsional)</label>
                        <input type="number" name="estimasi_anggaran" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_mulai">Tanggal Mulai Proyek</label>
                        <input type="date" name="tanggal_mulai" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="durasi_proyek">Durasi Proyek (Opsional)</label>
                        <input type="number" name="durasi_proyek" class="form-control" placeholder="Dalam hari">
                    </div>

                    <div class="mb-3">
                        <label for="image">Gambar (Opsional)</label>
                        <input type="file" name="image" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Posting Tugas</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
