<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Kontraktor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h4>Edit Profil Kontraktor</h4>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('kontraktor.profile.save') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <!-- Foto Profil -->
                        <div class="col-md-4 text-center">
                            <label for="foto_profile">
                                <img src="{{ asset(Auth::user()->kontraktorProfile->foto_profile ?? 'default-profile.png') }}"
                                     alt="Foto Profil" class="img-thumbnail" width="200">
                            </label>
                            <input type="file" name="foto_profile" id="foto_profile" class="form-control mt-2">
                        </div>

                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Nama Depan</label>
                                    <input type="text" name="nama_depan" class="form-control"
                                           value="{{ old('nama_depan', Auth::user()->kontraktorProfile->nama_depan ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Nama Belakang</label>
                                    <input type="text" name="nama_belakang" class="form-control"
                                           value="{{ old('nama_belakang', Auth::user()->kontraktorProfile->nama_belakang ?? '') }}" required>
                                </div>
                            </div>

                            <div class="mt-3">
                                <label>Nomor Telepon</label>
                                <input type="text" name="nomor_telepon" class="form-control"
                                       value="{{ old('nomor_telepon', Auth::user()->kontraktorProfile->nomor_telepon ?? '') }}" required>
                            </div>

                            <div class="mt-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control"
                                       value="{{ old('email', Auth::user()->kontraktorProfile->email ?? Auth::user()->email) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control" required>{{ old('alamat', Auth::user()->kontraktorProfile->alamat ?? '') }}</textarea>
                    </div>

                    <div class="mt-3">
                        <label>Nama Perusahaan</label>
                        <input type="text" name="nama_perusahaan" class="form-control"
                               value="{{ old('nama_perusahaan', Auth::user()->kontraktorProfile->nama_perusahaan ?? '') }}" required>
                    </div>

                    <div class="mt-3">
                        <label>Nomor NPWP</label>
                        <input type="text" name="nomor_npwp" class="form-control"
                               value="{{ old('nomor_npwp', Auth::user()->kontraktorProfile->nomor_npwp ?? '') }}">
                    </div>

                    <div class="mt-3">
                        <label>Bidang Usaha</label>
                        <input type="text" name="bidang_usaha" class="form-control"
                               value="{{ old('bidang_usaha', Auth::user()->kontraktorProfile->bidang_usaha ?? '') }}" required>
                    </div>

                    <!-- Dokumen Pendukung -->
                    <div class="mt-3">
                        <label>Dokumen Pendukung (PDF/DOC)</label>
                        <input type="file" name="dokumen_pendukung" class="form-control">
                        @if(Auth::user()->kontraktorProfile && Auth::user()->kontraktorProfile->dokumen_pendukung)
                            <p><a href="{{ asset('storage/' . Auth::user()->kontraktorProfile->dokumen_pendukung) }}" target="_blank">Lihat Dokumen</a></p>
                        @endif
                    </div>

                    <!-- Portofolio -->
                    <div class="mt-3">
                        <label>Portofolio (Gambar)</label>
                        <input type="file" name="portofolio" class="form-control">
                        @if(Auth::user()->kontraktorProfile && Auth::user()->kontraktorProfile->portofolio)
                            <p><img src="{{ asset('storage/' . Auth::user()->kontraktorProfile->portofolio) }}" class="img-thumbnail" width="200"></p>
                        @endif
                    </div>
                    <div class="mt-4 text-center">
                        <button type="submit" class="btn btn-primary">Simpan Profil</button>
                        <a href="{{ route('kontraktor.show') }}" class="btn btn-secondary ml-2">Lihat Profil</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
