<?php
    include 'hider.php';

    // ================== AMBIL DATA ==================
    $identitas = $pdo->query("SELECT * FROM pengaturan ORDER BY id ASC LIMIT 1");
    $d = $identitas->fetch(PDO::FETCH_OBJ);

    // kalau data tidak ada, berhenti
    if (!$d) {die("<h3 style='color:red'>Data pengaturan tidak ditemukan</h3>");}
    $id = $d->id;
?>

<div class="container" style="margin-top: 30px;">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title">ℹ️Tentang Sekolah</h3>
        </div>
        <div class="panel-body">
            <form method="POST" class="form-horizontal" enctype="multipart/form-data" style="margin-top: 15px;">

                <!-- Tentang Sekolah -->
                <div class="form-group">
                    <label class="col-sm-2" style="padding-top: 7px;">Tentang Sekolah</label>
                    <div class="col-sm-8">
                        <textarea name="tentang_sekolah" id="tentang_sekolah" class="form-control" rows="8" required">
                            <?= htmlspecialchars_decode($d->tentang_sekolah) ?>
                        </textarea>
                    </div>
                </div>

                <!-- Foto Sekolah -->
                <div class="form-group">
                    <label class="col-sm-2" style="padding-top: 7px;">Foto Sekolah</label>
                    <div class="col-sm-6">
                        <?php if (!empty($d->foto_sekolah)) { ?>
                            <img src="../uploads/identitas/<?= htmlspecialchars($d->foto_sekolah) ?>"
                                 style="max-width:300px; border:1px solid #ddd; padding:3px; border-radius:4px; margin-bottom:10px;">
                        <?php } else { ?>
                            <p><i>Tidak ada foto sekolah</i></p>
                        <?php } ?>

                        <input type="file" name="foto_sekolah" class="form-control" style="margin-top:10px;">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti foto sekolah.</small>
                    </div>
                </div>

                <!-- Tombol Simpan -->
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-6">
                        <button type="submit" name="submit" class="btn btn-success">📥Simpan</button>
                    </div>
                </div>
            </form>

            <?php
            // ================== PROSES SIMPAN ==================
            if (isset($_POST['submit'])) {

                // ambil ulang data lama
                $stmt2 = $pdo->prepare("SELECT * FROM pengaturan WHERE id = :id LIMIT 1");
                $stmt2->execute([':id' => $id]);
                $lama = $stmt2->fetch(PDO::FETCH_OBJ);
                $tentang_sekolah = $_POST['tentang_sekolah'];
                $foto_lama = $lama->foto_sekolah;

                $folder_upload = "../uploads/identitas/";
                if (!is_dir($folder_upload)) {
                    mkdir($folder_upload, 0777, true);
                }

                // HANDLE FOTO
                $foto_baru = $foto_lama;
                if (!empty($_FILES['foto_sekolah']['name'])) {

                    $nama_foto = time() . '_' . $_FILES['foto_sekolah']['name'];
                    $tmp_foto  = $_FILES['foto_sekolah']['tmp_name'];
                    if (move_uploaded_file($tmp_foto, $folder_upload . $nama_foto)) {
                        if (!empty($foto_lama) && file_exists($folder_upload . $foto_lama)) {
                            @unlink($folder_upload . $foto_lama);
                        }
                        $foto_baru = $nama_foto;
                    }
                }

                // UPDATE PDO
                $sql = "UPDATE pengaturan SET 
                            tentang_sekolah = :tentang,
                            foto_sekolah    = :foto
                        WHERE id = :id";

                $update = $pdo->prepare($sql)->execute([
                    ':tentang' => $tentang_sekolah,
                    ':foto'    => $foto_baru,
                    ':id'      => $id
                ]);

                if ($update) {
                    echo '<div class="alert alert-success" style="margin-top:15px;"><strong>Berhasil!</strong> Data tentang sekolah berhasil diperbarui.</div>';
                    echo '<meta http-equiv="refresh" content="1; url=tentangsekolah.php">';
                } else {
                    echo '<div class="alert alert-danger" style="margin-top:15px;"><strong>Gagal!</strong> Terjadi kesalahan update.</div>';
                }
            }
            ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('tentang_sekolah', {
        height: 250
    });
</script>

