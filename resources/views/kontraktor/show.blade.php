<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Kontraktor</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f9f9f9; }
        .container { max-width: 700px; margin: auto; padding: 20px; background: #fff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        h2 { text-align: center; color: #333; }
        .info { margin-bottom: 10px; font-size: 16px; }
        .profile-img { display: block; margin: 10px auto; width: 150px; height: 150px; object-fit: cover; border-radius: 50%; border: 2px solid #ddd; }
        .grid { display: grid; gap: 10px; }
        .grid-2 { grid-template-columns: repeat(2, 1fr); }
        .grid-3 { grid-template-columns: repeat(3, 1fr); }
        .grid-4 { grid-template-columns: repeat(4, 1fr); }
        .pdf-preview { width: 100px; height: 120px; border: 1px solid #ccc; border-radius: 5px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1); }
        .alert { padding: 10px; border-radius: 5px; text-align: center; font-weight: bold; }
        .alert-success { background-color: #d4edda; color: #155724; }
        .alert-danger { background-color: #f8d7da; color: #721c24; }
        .alert-warning { background-color: #fff3cd; color: #856404; }
        .portfolio-img { width: 100%; height: auto; border-radius: 8px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1); transition: transform 0.3s; }
        .portfolio-img:hover { transform: scale(1.05); }
    </style>
</head>
<body>
    <div class="container">
        <h2>Profil Kontraktor</h2>

        @if($kontraktor->foto_profile)
            <img src="{{ asset('storage/' . $kontraktor->foto_profile) }}" alt="Foto Profil" class="profile-img">
        @else
            <p style="text-align: center; color: #888;">(Tidak ada foto profil)</p>
        @endif

        <div class="info"><strong>Nama:</strong> {{ $kontraktor->nama_depan }} {{ $kontraktor->nama_belakang }}</div>
        <div class="info"><strong>Email:</strong> {{ $kontraktor->email }}</div>
        <div class="info"><strong>Perusahaan:</strong> {{ $kontraktor->nama_perusahaan }}</div>
        <div class="info"><strong>Alamat:</strong> {{ $kontraktor->alamat }}</div>
        <div class="info"><strong>Telepon:</strong> {{ $kontraktor->nomor_telepon }}</div>

        <h3>Dokumen Pendukung</h3>
        <div class="grid grid-2">
            @foreach($kontraktor->files->where('file_type', 'dokumen_pendukung') as $file)
                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">
                    <canvas id="pdf-preview-{{ $loop->index }}" class="pdf-preview"></canvas>
                </a>
            @endforeach
        </div>

        <h3>Portofolio</h3>
        <div class="grid grid-3">
            @foreach($kontraktor->files->where('file_type', 'portofolio') as $file)
                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank">
                    <img src="{{ asset('storage/' . $file->file_path) }}" class="portfolio-img">
                </a>
            @endforeach
        </div>

        <h3>Status Profil</h3>
        @if($kontraktor->status == 1)
            <div class="alert alert-success">Profil Anda telah <strong>diterima</strong> oleh admin.</div>
        @elseif($kontraktor->status == 0)
            <div class="alert alert-danger">Profil Anda <strong>ditolak</strong> oleh admin.</div>
            @if($kontraktor->catatan_admin)
                <div class="mt-3">
                    <strong>Catatan Admin:</strong>
                    <p>{{ $kontraktor->catatan_admin }}</p>
                </div>
            @endif
        @else
            <div class="alert alert-warning">Profil Anda sedang <strong>menunggu persetujuan</strong> admin.</div>
        @endif
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            @foreach($kontraktor->files->where('file_type', 'dokumen_pendukung') as $file)
                var url = "{{ asset('storage/' . $file->file_path) }}";
                var canvasId = "pdf-preview-{{ $loop->index }}";

                var loadingTask = pdfjsLib.getDocument(url);
                loadingTask.promise.then(function (pdf) {
                    pdf.getPage(1).then(function (page) {
                        var scale = 0.8;
                        var viewport = page.getViewport({ scale: scale });
                        var canvas = document.getElementById(canvasId);
                        var context = canvas.getContext('2d');

                        canvas.width = viewport.width;
                        canvas.height = viewport.height;

                        var renderContext = { canvasContext: context, viewport: viewport };
                        page.render(renderContext);
                    });
                });
            @endforeach
        });
    </script>
</body>
</html>
