<?php
require __DIR__ . '/config/db.php';
include __DIR__ . '/includes/header.php';

$search = isset($_GET['q']) ? trim($_GET['q']) : '';

try {
    if ($search !== '') {
        $stmt = $pdo->prepare(
            "SELECT * FROM tracks
             WHERE title LIKE :q OR artist LIKE :q OR album LIKE :q OR genre LIKE :q
             ORDER BY id DESC"
        );
        $like = '%' . $search . '%';
        $stmt->bindValue(':q', $like, PDO::PARAM_STR);
    } else {
        $stmt = $pdo->prepare("SELECT * FROM tracks ORDER BY id DESC");
    }
    $stmt->execute();
    $tracks = $stmt->fetchAll();
} catch (PDOException $e) {
    $tracks = [];
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Gagal mengambil data lagu.'];
}
?>

<div class="page-header">
    <div>
        <h1 class="h3 mb-1 fw-bold">Library Musik</h1>
        <p class="text-secondary mb-0">Kelola koleksi lagu layaknya Spotify versi kampus</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <form class="search-bar" method="get" action="list.php">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Cari judul, artis, album, genre" value="<?php echo htmlspecialchars($search); ?>">
                <button class="btn btn-outline-light" type="submit">Cari</button>
            </div>
        </form>
        <a href="add.php" class="btn btn-spotify d-flex align-items-center gap-2">+ Tambah Lagu</a>
    </div>
</div>

<div class="card card-gradient">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-dark align-middle table-hover table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cover</th>
                        <th>Judul</th>
                        <th>Artis</th>
                        <th>Album</th>
                        <th>Tahun</th>
                        <th>Genre</th>
                        <th>Durasi</th>
                        <th>Audio</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (count($tracks) === 0): ?>
                    <tr>
                        <td colspan="10" class="text-center text-secondary">Data tidak ditemukan.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($tracks as $index => $track): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td>
                                <?php if (!empty($track['cover_url'])): ?>
                                    <img src="<?php echo htmlspecialchars($track['cover_url']); ?>" alt="Cover" class="cover-thumb">
                                <?php else: ?>
                                    <div class="cover-thumb d-flex align-items-center justify-content-center bg-secondary text-dark fw-bold">N/A</div>
                                <?php endif; ?>
                            </td>
                            <td class="fw-semibold"><?php echo htmlspecialchars($track['title']); ?></td>
                            <td><?php echo htmlspecialchars($track['artist']); ?></td>
                            <td><?php echo htmlspecialchars($track['album']); ?></td>
                            <td><?php echo htmlspecialchars($track['year']); ?></td>
                            <td><span class="badge bg-secondary"><?php echo htmlspecialchars($track['genre']); ?></span></td>
                            <td><?php echo htmlspecialchars($track['duration']); ?></td>
                            <td>
                                <?php if (!empty($track['audio_url'])): ?>
                                    <a class="btn btn-sm btn-outline-light" href="<?php echo htmlspecialchars($track['audio_url']); ?>" target="_blank">Putar</a>
                                <?php else: ?>
                                    <span class="text-secondary">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="edit.php?id=<?php echo $track['id']; ?>" class="btn btn-sm btn-outline-warning">Edit</a>
                                    <form action="delete.php" method="post" onsubmit="return confirm('Hapus lagu ini?');">
                                        <input type="hidden" name="id" value="<?php echo $track['id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
