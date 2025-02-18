<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Kontraktor</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; }
        h2 { text-align: center; }
        .info { margin-bottom: 10px; }
        .profile-img { display: block; margin: 10px auto; width: 150px; height: 150px; object-fit: cover; border-radius: 50%; }
        .link { display: block; margin-top: 5px; color: blue; text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Profil Kontraktor</h2>

        <!-- Foto Profil -->
        @if($kontraktor->foto_profile)
            <img src="{{ asset('storage/' . $kontraktor->foto_profile) }}" alt="Foto Profil" class="profile-img">
        @else
            <p style="text-align: center;">(Tidak ada foto profil)</p>
        @endif

        <div class="info"><strong>Nama:</strong> {{ $kontraktor->nama_depan }}</div>
        <div class="info"><strong>Email:</strong> {{ $kontraktor->email }}</div>
        <div class="info"><strong>Perusahaan:</strong> {{ $kontraktor->nama_perusahaan }}</div>
        <div class="info"><strong>Alamat:</strong> {{ $kontraktor->alamat }}</div>
        <div class="info"><strong>Telepon:</strong> {{ $kontraktor->nomor_telepon }}</div>

        <!-- Dokumen Pendukung -->
        @if($kontraktor->dokumen_pendukung)
            <div class="info">
                <strong>Dokumen Pendukung:</strong>
                <a href="{{ asset('storage/' . $kontraktor->dokumen_pendukung) }}" class="link" target="_blank">Lihat Dokumen</a>
            </div>
        @else
            <div class="info"><strong>Dokumen Pendukung:</strong> Tidak ada</div>
        @endif

        <!-- Portofolio -->
        @if($kontraktor->portofolio)
            <div class="info">
                <strong>Portofolio:</strong>
                <a href="{{ asset('storage/' . $kontraktor->portofolio) }}" class="link" target="_blank">Lihat Portofolio</a>
            </div>
        @else
            <div class="info"><strong>Portofolio:</strong> Tidak ada</div>
        @endif

        <div class="card mt-4">
            <div class="card-header">
                <h5>Status Profil</h5>
            </div>
            <div class="card-body">
                @if($kontraktor->status == 1)
                    <div class="alert alert-success">
                        Profil Anda telah <strong>diterima</strong> oleh admin.
                    </div>
                @elseif($kontraktor->status == 0)
                    <div class="alert alert-danger">
                        Profil Anda <strong>ditolak</strong> oleh admin.
                    </div>
                    @if($kontraktor->catatan_admin)
                        <div class="mt-3">
                            <strong>Catatan Admin:</strong>
                            <p>{{ $kontraktor->catatan_admin }}</p>
                        </div>
                    @endif
                @else
                    <div class="alert alert-warning">
                        Profil Anda sedang <strong>menunggu persetujuan</strong> admin.
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
