<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: #f0f2f5;
        }
        .post-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 15px;
            margin-bottom: 20px;
        }
        .user-info {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .post-image {
            width: 150px; /* Gambar Kotak */
            height: 150px; /* Gambar Kotak */
            object-fit: cover; /* Supaya gambar tidak melar */
            border-radius: 5px; /* Supaya sudut tidak terlalu tajam */
            margin-bottom: 10px;
            display: block;
        }
        .post-footer {
            display: flex;
            justify-content: space-between;
            padding-top: 10px;
            border-top: 1px solid #ddd;
        }
        .post-footer button {
            background: none;
            border: none;
            color: #65676b;
            font-size: 16px;
            cursor: pointer;
        }
        .post-footer button:hover {
            color: #1877f2;
        }
        .comments-section {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
        }
        .comment-form {
            margin-top: 15px;
        }
    </style>
    <script>
        function likeTask(taskId) {
            fetch(`/task/${taskId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                const likeCount = document.getElementById(`like-count-${taskId}`);
                likeCount.textContent = parseInt(likeCount.textContent) + (data.status === 'liked' ? 1 : -1);
            });
        }

        function interestTask(taskId) {
            fetch(`/task/${taskId}/interest`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'error') {
                    alert(data.message);
                } else {
                    const interestCount = document.getElementById(`interest-count-${taskId}`);
                    interestCount.textContent = parseInt(interestCount.textContent) + (data.status === 'interested' ? 1 : -1);
                }
            });
        }
    </script>
</head>
<body>

<div class="container mt-4">
    <h2 class="text-center mb-4">Daftar Tugas yang Tersedia</h2>

    @if ($tasks->count() > 0)
        @foreach ($tasks as $task)
            <div class="post-card">
                <!-- Bagian User Info -->
                <div class="user-info">
                    <!-- Ambil Foto Profil User, Jika Tidak Ada Pakai Placeholder -->
                    <img src="{{ $task->user->foto_profil ? asset('storage/' . $task->user->foto_profil) : 'https://via.placeholder.com/45' }}"
                         class="user-avatar" alt="User Avatar">

                    <div>
                        <strong>{{ $task->user->name }}</strong><br>
                        <small class="text-muted">{{ \Carbon\Carbon::parse($task->tanggal_mulai)->diffForHumans() }}</small>
                    </div>
                </div>

                <!-- Gambar Kotak -->
                @if ($task->image)
                    <img src="{{ asset('storage/' . $task->image) }}" class="post-image" alt="Gambar Tugas">
                @else
                    <img src="https://via.placeholder.com/150" class="post-image" alt="Placeholder">
                @endif

                <!-- Deskripsi -->
                <p><strong>Lokasi:</strong> {{ $task->lokasi_proyek }}</p>
                <p><strong>Estimasi Anggaran:</strong> {{ $task->estimasi_anggaran ? 'Rp ' . number_format($task->estimasi_anggaran, 0, ',', '.') : 'Tidak ada estimasi' }}</p>
                <p><strong>Durasi:</strong> {{ $task->durasi_proyek ? $task->durasi_proyek . ' hari' : 'Tidak diketahui' }}</p>

                <div class="post-footer">
                    <!-- Like Button -->
                    <button onclick="likeTask({{ $task->id }})">
                        <i class="far fa-thumbs-up"></i> Suka (<span id="like-count-{{ $task->id }}">{{ $task->likes->count() }}</span>)
                    </button>

                    <!-- Comment Button -->
                    <button>
                        <i class="far fa-comment"></i> Komentar (<span id="comment-count-{{ $task->id }}">{{ $task->comments->count() }}</span>)
                    </button>

                    <!-- Tertarik Button (Hanya untuk Kontraktor) -->
                    @if (Auth::check() && Auth::user()->role === 'kontraktor')
                        <button onclick="interestTask({{ $task->id }})">
                            <i class="far fa-star"></i> Tertarik (<span id="interest-count-{{ $task->id }}">{{ $task->interests->count() }}</span>)
                        </button>
                    @endif
                </div>

                <!-- Bagian Komentar -->
                <div class="comments-section">
                    <h6>Komentar:</h6>
                    <div id="comments-{{ $task->id }}">
                        @foreach ($task->comments as $comment)
                            <div class="mb-2">
                                <strong>{{ $comment->user->name }}</strong>: {{ $comment->comment }}
                            </div>
                        @endforeach
                    </div>

                    <!-- Form Komentar -->
                    <div class="comment-form">
                        <form action="{{ route('task.comment', $task->id) }}" method="POST">
                            @csrf
                            <textarea name="comment" class="form-control" rows="3" required></textarea>
                            <button type="submit" class="btn btn-primary mt-2">Kirim</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="alert alert-info text-center">
            Belum ada tugas yang diposting.
        </div>
    @endif
</div>

</body>
</html>
