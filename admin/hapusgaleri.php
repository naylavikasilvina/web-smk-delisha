<?php
    include '../koneksi.php';

    if (isset($_GET['id'])) {$id = $_GET['id'];

        // Ambil foto lama
        $stmt = $pdo->prepare("SELECT foto FROM galeri WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {

            $path = "../uploads/galeri/";
            $foto = $data['foto'];

            // Hapus file foto jika ada
            if (!empty($foto) && file_exists($path . $foto)) {
                unlink($path . $foto);
            }

            // Hapus data dari database
            $delete = $pdo->prepare("DELETE FROM galeri WHERE id = :id");
            $delete->execute([':id' => $id]);
        }
        echo "<script>window.location='galeri.php'</script>";
    }
?>
