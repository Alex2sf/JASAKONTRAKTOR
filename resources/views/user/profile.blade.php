<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h4>Profil User</h4>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('user.profile.save') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" value="{{ $profile->nama_lengkap ?? '' }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="alamat_lengkap">Alamat Lengkap</label>
                        <textarea name="alamat_lengkap" class="form-control" required>{{ $profile->alamat_lengkap ?? '' }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="nomor_telepon">Nomor Telepon</label>
                        <input type="text" name="nomor_telepon" class="form-control" value="{{ $profile->nomor_telepon ?? '' }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $profile->email ?? Auth::user()->email }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="foto_profil">Foto Profil</label>
                        <input type="file" name="foto_profil" class="form-control">
                        @if($profile && $profile->foto_profil)
                            <img src="{{ asset('storage/' . $profile->foto_profil) }}" class="img-thumbnail mt-2" width="150">
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Profil</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
