<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Daftar Kontraktor</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kontraktors as $kontraktor)
                    <tr>
                        <td>{{ $kontraktor->nama_depan }} {{ $kontraktor->nama_belakang }}</td>
                        <td>{{ $kontraktor->email }}</td>
                        <td>{{ $kontraktor->status == 0 ? 'Menunggu Persetujuan' : 'Diterima' }}</td>
                        <td>
                            <a href="{{ route('admin.approve_kontraktor', $kontraktor->id) }}" class="btn btn-primary">Review</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
