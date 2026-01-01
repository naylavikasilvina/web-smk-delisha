<?php
include '../koneksi.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $delete = $pdo->prepare("DELETE FROM pengguna WHERE id = ?");
        $delete->execute([$id]);

        echo "<script>window.location = 'pengguna.php'</script>";
        exit;
    } catch (PDOException $e) {
        echo "Gagal menghapus data: " . $e->getMessage();
    }

} else {
    echo "<script>window.location = 'pengguna.php'</script>";
    exit;
}
