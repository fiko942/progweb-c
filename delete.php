<?php
require __DIR__ . '/config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /list.php');
    exit;
}

$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

if ($id <= 0) {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'ID tidak valid.'];
    header('Location: /list.php');
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM tracks WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Lagu berhasil dihapus.'];
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Gagal menghapus lagu.'];
}

header('Location: /list.php');
exit;
