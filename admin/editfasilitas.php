<?php 
    include 'hider.php'; 
    include '../koneksi.php'; 

    // Cek ID
    if (!isset($_GET['id']) || $_GET['id'] == '') {
        echo "<script>window.location='fasilitas.php'</script>";
        exit;
    }

    $id = (int) $_GET['id'];

    // Ambil data galeri
    $stmt = $pdo->prepare("SELECT * FROM fasilitas WHERE id = ?");
    $stmt->execute([$id]);
    $p = $stmt->fetch(PDO::FETCH_OBJ);

    if (!$p) {
        echo "<script>window.location='fasilitas.php'</script>";
        exit;
    }
?>

<div class="container" style="margin-top: 30px;">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">🖼️Edit Fasilitas</h3>
        </div>

        <div class="panel-body">
            <form method="POST" enctype="multipart/form-data" class="form-horizontal">

                <!-- Keterangan -->
                <div class="form-group">
                    <label class="col-sm-2 text-left">Keterangan</label>
                    <div class="col-sm-6">
                        <textarea 
                            name="keterangan" 
                            class="form-control" 
                            rows="10" 
                            required><?= htmlspecialchars($p->keterangan) ?>
                        </textarea>
                    </div>
                </div>

                <!-- Foto Lama -->
                <div class="form-group">
                    <label class="col-sm-2 text-left">Foto Lama</label>
                    <div class="col-sm-6">
                        <img src="../uploads/fasilitas/<?= htmlspecialchars($p->foto); ?>" width="120">
                    </div>
                </div>

                <!-- Upload Foto Baru -->
                <div class="form-group">
                    <label class="col-sm-2 text-left">Ganti Foto</label>
                    <div class="col-sm-6">
                        <input type="file" name="foto" class="form-control">
                        <small class="text-muted">
                            Kosongkan jika tidak ingin mengganti foto
                        </small>
                    </div>
                </div>

                <!-- Tombol -->
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-6">
                        <button type="submit" name="submit" class="btn btn-info">📝edit</button>
                        <a href="fasilitas.php" class="btn btn-default">◀️Kembali</a>
                    </div>
                </div>
            </form>

            <?php
                if (isset($_POST['submit'])) {
                    $keterangan = trim($_POST['keterangan']);
                    $foto_lama  = $p->foto;
                    $path       = "../uploads/fasilitas/";

                    // Jika ganti foto
                    if (!empty($_FILES['foto']['name'])) {
                        $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
                        $allowed = ['jpg','jpeg','png','gif'];

                        if (!in_array($ext, $allowed)) {
                            echo '<div class="alert alert-danger">Format gambar tidak didukung.</div>';
                        } else {
                            // pastikan folder ada
                            if (!is_dir($path)) {
                                mkdir($path, 0777, true);
                            }

                            $foto_baru = "galeri_" . time() . "." . $ext;

                            // upload
                            move_uploaded_file($_FILES['foto']['tmp_name'], $path . $foto_baru);

                            // hapus foto lama
                            if (!empty($foto_lama) && file_exists($path . $foto_lama)) {
                                unlink($path . $foto_lama);
                            }

                            // update dengan foto baru
                            $update = $pdo->prepare("
                                UPDATE fasilitas 
                                SET keterangan = ?, foto = ?, update_at = NOW()
                                WHERE id = ?
                            ");
                            $sukses = $update->execute([$keterangan, $foto_baru, $id]);
                        }

                    } else {
                        // update tanpa ganti foto
                        $update = $pdo->prepare("
                            UPDATE fasilitas 
                            SET  keterangan = ?, update_at = NOW()
                            WHERE id = ?
                        ");
                        $sukses = $update->execute([ $keterangan, $id]);
                    }

                    if (!empty($sukses)) {
                        echo '<div class="alert alert-success" style="margin-top:15px;">Galeri berhasil diperbarui.</div>';
                    } else {
                        echo '<div class="alert alert-danger" style="margin-top:15px;">Terjadi kesalahan saat menyimpan.</div>';
                    }
                }
            ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
