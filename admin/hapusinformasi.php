<?php
    include '../koneksi.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        try {

            // ambil gambar lama
            $stmt = $pdo->prepare("SELECT gambar FROM informasi WHERE id = :id LIMIT 1");
            $stmt->execute([':id' => $id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                $path = "../uploads/informasi/";
                $gambar = $data['gambar'];

                // hapus file gambar jika ada
                if (!empty($gambar) && file_exists($path . $gambar)) {
                    unlink($path . $gambar);
                }

                // hapus data
                $hapus = $pdo->prepare("DELETE FROM informasi WHERE id = :id");
                $hapus->execute([':id' => $id]);
            }echo "<script>window.location='informasi.php'</script>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
?>
