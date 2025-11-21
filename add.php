<?php
require __DIR__ . '/config/db.php';
include __DIR__ . '/includes/header.php';

$errors = [];
$data = [
    'title' => '',
    'artist' => '',
    'album' => '',
    'year' => '',
    'genre' => '',
    'duration' => '',
    'cover_url' => '',
    'audio_url' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($data as $field => $value) {
        $data[$field] = trim($_POST[$field] ?? '');
    }

    foreach ($data as $field => $value) {
        if ($value === '') {
            $errors[] = ucfirst($field) . ' wajib diisi.';
        }
    }

    if ($data['year'] !== '' && !ctype_digit($data['year'])) {
        $errors[] = 'Tahun harus berupa angka.';
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare(
                "INSERT INTO tracks (title, artist, album, year, genre, duration, cover_url, audio_url)
                 VALUES (:title, :artist, :album, :year, :genre, :duration, :cover_url, :audio_url)"
            );
            $stmt->execute([
                ':title' => $data['title'],
                ':artist' => $data['artist'],
                ':album' => $data['album'],
                ':year' => (int) $data['year'],
                ':genre' => $data['genre'],
                ':duration' => $data['duration'],
                ':cover_url' => $data['cover_url'],
                ':audio_url' => $data['audio_url'],
            ]);
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Lagu berhasil ditambahkan.'];
            header('Location: /list.php');
            exit;
        } catch (PDOException $e) {
            $errors[] = 'Gagal menyimpan data. Coba lagi.';
        }
    }
}
?>

<div class="page-header">
    <div>
        <h1 class="h3 fw-bold mb-1">Tambah Lagu</h1>
        <p class="text-secondary mb-0">Lengkapi detail lagu untuk dimasukkan ke library</p>
    </div>
    <a href="list.php" class="btn btn-outline-light">Kembali</a>
</div>

<div class="card card-gradient">
    <div class="card-body">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="add.php" class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Judul</label>
                <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($data['title']); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Artis</label>
                <input type="text" name="artist" class="form-control" value="<?php echo htmlspecialchars($data['artist']); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Album</label>
                <input type="text" name="album" class="form-control" value="<?php echo htmlspecialchars($data['album']); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Tahun</label>
                <input type="text" name="year" class="form-control" value="<?php echo htmlspecialchars($data['year']); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Genre</label>
                <input type="text" name="genre" class="form-control" value="<?php echo htmlspecialchars($data['genre']); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Durasi (mm:ss)</label>
                <input type="text" name="duration" class="form-control" placeholder="03:45" value="<?php echo htmlspecialchars($data['duration']); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">URL Cover</label>
                <input type="url" name="cover_url" class="form-control" placeholder="https://..." value="<?php echo htmlspecialchars($data['cover_url']); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">URL Audio</label>
                <input type="url" name="audio_url" class="form-control" placeholder="https://..." value="<?php echo htmlspecialchars($data['audio_url']); ?>" required>
            </div>
            <div class="col-12 d-flex justify-content-end gap-2">
                <a href="list.php" class="btn btn-outline-light">Batal</a>
                <button type="submit" class="btn btn-spotify">Simpan</button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
