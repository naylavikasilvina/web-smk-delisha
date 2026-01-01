<?php include 'hider.php'; ?>
<div class="container" style="margin-top: 30px;">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title">🖼️Tambah Galeri</h3>
        </div>

        <div class="panel-body">
            <form method="POST" enctype="multipart/form-data" class="form-horizontal">

                <!-- judul -->
                <div class="form-group">
                    <label class="col-sm-2 text-left">Judul</label>
                    <div class="col-sm-6">
                        <input type="text" name="judul" class="form-control" placeholder="judul" required>
                    </div>
                </div>

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
                        <textarea name="keterangan" class="form-control" rows="5" placeholder="Keterangan"></textarea>
                    </div>
                </div>

                <!-- Tombol -->
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-6">
                        <button type="submit" name="submit" class="btn btn-success">📥Simpan</button>
                        <a href="galeri.php" class="btn btn-default"> ◀️Kembali</a>
                    </div>
                </div>
            </form>

            <?php
                if (isset($_POST["submit"])) {
                    include '../koneksi.php';

                    // --- Upload Gambar ---
                    $filename   = $_FILES['foto']['name'];
                    $tmpname    = $_FILES['foto']['tmp_name'];
                    $formatfile = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                    $rename     = 'galeri' . time() . '.' . $formatfile;

                    $allowedtype = ['png','jpg','jpeg','gif'];

                    if (!in_array($formatfile, $allowedtype)) {
                        echo '<div class="alert alert-danger"><strong>Format file tidak didukung!</strong></div>';
                    } else {

                        $uploadPath = "../uploads/galeri/";

                        if (!is_dir($uploadPath)) {
                            mkdir($uploadPath, 0777, true);
                        }

                        move_uploaded_file($tmpname, $uploadPath . $rename);

                        // Ambil data input (PDO sudah aman jadi tidak perlu escape manual)
                        $judul         = trim($_POST['judul']);
                        $keterangan   = trim($_POST['keterangan']);

                        // Cek duplikat nama jurusan
                        $cek = $pdo->prepare("SELECT id FROM galeri WHERE judul = ?");
                        $cek->execute([$judul]);

                        if ($cek->rowCount() > 0) {
                            echo '<div class="alert alert-danger"><strong>Maaf!</strong> Nama jurusan sudah digunakan.</div>';
                        } else {
                            $simpan = $pdo->prepare("
                                INSERT INTO galeri (judul, foto, keterangan)
                                VALUES (?, ?, ?)
                            ");
                            $save = $simpan->execute([
                                $judul,
                                $rename,
                                $keterangan,
                            ]);

                            if ($save) {
                                echo '<div class="alert alert-success"><strong>Berhasil!</strong> Data jurusan berhasil disimpan.</div>';
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
