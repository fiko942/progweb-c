<?php
require __DIR__ . '/config/db.php';
include __DIR__ . '/includes/header.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'ID lagu tidak valid.'];
    header('Location: /list.php');
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM tracks WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $track = $stmt->fetch();
} catch (PDOException $e) {
    $track = false;
}

if (!$track) {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Lagu tidak ditemukan.'];
    header('Location: /list.php');
    exit;
}

$data = $track;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = ['title', 'artist', 'album', 'year', 'genre', 'duration', 'cover_url', 'audio_url'];
    foreach ($fields as $field) {
        $data[$field] = trim($_POST[$field] ?? '');
        if ($data[$field] === '') {
            $errors[] = ucfirst($field) . ' wajib diisi.';
        }
    }

    if ($data['year'] !== '' && !ctype_digit($data['year'])) {
        $errors[] = 'Tahun harus berupa angka.';
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare(
                "UPDATE tracks SET title = :title, artist = :artist, album = :album, year = :year,
                 genre = :genre, duration = :duration, cover_url = :cover_url, audio_url = :audio_url
                 WHERE id = :id"
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
                ':id' => $id
            ]);
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Data lagu berhasil diperbarui.'];
            header('Location: /list.php');
            exit;
        } catch (PDOException $e) {
            $errors[] = 'Gagal memperbarui data. Coba lagi.';
        }
    }
}
?>

<div class="page-header">
    <div>
        <h1 class="h3 fw-bold mb-1">Edit Lagu</h1>
        <p class="text-secondary mb-0">Perbarui detail lagu yang sudah ada</p>
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

        <form method="post" action="edit.php?id=<?php echo $id; ?>" class="row g-3">
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
                <input type="text" name="duration" class="form-control" value="<?php echo htmlspecialchars($data['duration']); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">URL Cover</label>
                <input type="url" name="cover_url" class="form-control" value="<?php echo htmlspecialchars($data['cover_url']); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">URL Audio</label>
                <input type="url" name="audio_url" class="form-control" value="<?php echo htmlspecialchars($data['audio_url']); ?>" required>
            </div>
            <div class="col-12 d-flex justify-content-end gap-2">
                <a href="list.php" class="btn btn-outline-light">Batal</a>
                <button type="submit" class="btn btn-spotify">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
