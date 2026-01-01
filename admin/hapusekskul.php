<?php
include '../koneksi.php';  

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil gambar lama
    $stmt = $pdo->prepare("SELECT gambar FROM ekskul WHERE id = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        $path = "../uploads/ekskul/";
        $gambar = $data['gambar'];

        // Hapus file gambar jika ada
        if (!empty($gambar) && file_exists($path . $gambar)) {
            unlink($path . $gambar);
        }

        // Hapus data di database
        $delete = $pdo->prepare("DELETE FROM ekskul WHERE id = ?");
        $delete->execute([$id]);
    }

    echo "<script>window.location='ekskul.php'</script>";
}
?>
