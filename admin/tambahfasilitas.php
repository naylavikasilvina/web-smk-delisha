<?php include 'hider.php'; ?>
<div class="container" style="margin-top: 30px;">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title">🖼️ Tambah Fasilitas</h3>
        </div>

        <div class="panel-body">
            <form method="POST" enctype="multipart/form-data" class="form-horizontal">

                <!-- Gambar -->
                <div class="form-group">
                    <label class="col-sm-2 text-left">Foto</label>
                    <div class="col-sm-6">
                        <input type="file" name="foto" class="form-control" required>
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="form-group">
                    <label class="col-sm-2 text-left">Keterangan</label>
                    <div class="col-sm-6">
                        <textarea name="keterangan" class="form-control" rows="5" required placeholder="Keterangan fasilitas"></textarea>
                    </div>
                </div>

                <!-- Tombol -->
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-6">
                        <button type="submit" name="submit" class="btn btn-success">📥 Simpan</button>
                        <a href="fasilitas.php" class="btn btn-default">◀️ Kembali</a>
                    </div>
                </div>
            </form>

<?php
if (isset($_POST["submit"])) {
    include '../koneksi.php';

    $filename   = $_FILES['foto']['name'];
    $tmpname    = $_FILES['foto']['tmp_name'];
    $ext        = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $rename     = 'fasilitas_' . time() . '.' . $ext;

    $allowed = ['png','jpg','jpeg','gif'];

    if (!in_array($ext, $allowed)) {
        echo '<div class="alert alert-danger"><strong>Format file tidak didukung!</strong></div>';
    } else {

        $uploadPath = "../uploads/fasilitas/";
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        move_uploaded_file($tmpname, $uploadPath . $rename);

        $keterangan = trim($_POST['keterangan']);

        // Cek duplikat berdasarkan keterangan (opsional)
        $cek = $pdo->prepare("SELECT id FROM fasilitas WHERE keterangan = ?");
        $cek->execute([$keterangan]);

        if ($cek->rowCount() > 0) {
            echo '<div class="alert alert-danger"><strong>Maaf!</strong> Fasilitas dengan keterangan ini sudah ada.</div>';
        } else {
            $simpan = $pdo->prepare("
                INSERT INTO fasilitas (foto, keterangan)
                VALUES (?, ?)
            ");

            $save = $simpan->execute([
                $rename,
                $keterangan
            ]);

            if ($save) {
                echo '<div class="alert alert-success"><strong>Berhasil!</strong> Data fasilitas berhasil disimpan.</div>';
                echo '<meta http-equiv="refresh" content="1; url=fasilitas.php">';
            } else {
                echo '<div class="alert alert-danger"><strong>Gagal!</strong> Data tidak tersimpan.</div>';
            }
        }
    }
}
?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
