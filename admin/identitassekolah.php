<?php
include 'hider.php'; // pastikan di sini sudah ada $pdo

error_reporting(E_ALL);
ini_set('display_errors', 1);

$id = $d->id;

if (isset($_POST['submit'])) {

    $lama = $d;
    $nama   = $_POST['nama'];
    $email  = $_POST['email'];
    $telpon = $_POST['telpon'];
    $alamat = $_POST['alamat'];
    $maps   = $_POST['maps'];

    $logo_lama    = $lama->logo;
    $favicon_lama = $lama->favicon;

    $folder_upload = "../uploads/identitas/";
    if (!is_dir($folder_upload)) {
        mkdir($folder_upload, 0777, true);
    }

    // ================= LOGO =================
    $logo_baru = $logo_lama;
    if (!empty($_FILES['logo']['name'])) {
        $nama_logo = time().'_'.$_FILES['logo']['name'];
        $tmp_logo  = $_FILES['logo']['tmp_name'];

        if (move_uploaded_file($tmp_logo, $folder_upload.$nama_logo)) {
            if (!empty($logo_lama) && file_exists($folder_upload.$logo_lama)) {
                @unlink($folder_upload.$logo_lama);
            }
            $logo_baru = $nama_logo;
        }
    }

    // ================= FAVICON =================
    $favicon_baru = $favicon_lama;
    if (!empty($_FILES['favicon']['name'])) {
        $nama_favicon = time().'_'.$_FILES['favicon']['name'];
        $tmp_favicon  = $_FILES['favicon']['tmp_name'];

        if (move_uploaded_file($tmp_favicon, $folder_upload.$nama_favicon)) {
            if (!empty($favicon_lama) && file_exists($folder_upload.$favicon_lama)) {
                @unlink($folder_upload.$favicon_lama);
            }
            $favicon_baru = $nama_favicon;
        }
    }

    // ================= UPDATE PDO =================
    $sql = "UPDATE pengaturan SET 
                nama = :nama,
                email = :email,
                telpon = :telpon,
                alamat = :alamat,
                maps = :maps,
                logo = :logo,
                favicon = :favicon
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    $update = $stmt->execute([
        ':nama'     => $nama,
        ':email'    => $email,
        ':telpon'   => $telpon,
        ':alamat'   => $alamat,
        ':maps'     => $maps,
        ':logo'     => $logo_baru,
        ':favicon'  => $favicon_baru,
        ':id'       => $id
    ]);

    if ($update) {
        echo '<div class="alert alert-success" style="margin-top:15px;">
                <strong>Berhasil!</strong> Data identitas sekolah berhasil diperbarui.
              </div>';
        echo '<meta http-equiv="refresh" content="1; url=identitassekolah.php">';
        exit;
    } else {
        echo '<div class="alert alert-danger" style="margin-top:15px;">
                <strong>Gagal!</strong> Gagal update data.
              </div>';
    }
}
?>

<div class="container" style="margin-top: 30px;">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title">🏫Identitas Sekolah</h3>
        </div>

        <div class="panel-body">
            <pre>
                <?php var_dump($d->logo); ?>
            </pre>

            <form method="POST" class="form-horizontal" enctype="multipart/form-data" style="margin-top: 15px;">

                <!-- Nama -->
                <div class="form-group">
                    <label class="col-sm-2" style="padding-top: 7px;">Nama</label>
                    <div class="col-sm-6">
                        <input type="text" name="nama" class="form-control"
                               value="<?= htmlspecialchars($d->nama) ?>" required>
                    </div>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label class="col-sm-2" style="padding-top: 7px;">Email</label>
                    <div class="col-sm-6">
                        <input type="email" name="email" class="form-control"
                               value="<?= htmlspecialchars($d->email) ?>" required>
                    </div>
                </div>

                <!-- Telepon -->
                <div class="form-group">
                    <label class="col-sm-2" style="padding-top: 7px;">Telepon</label>
                    <div class="col-sm-6">
                        <input type="text" name="telpon" class="form-control"
                               value="<?= htmlspecialchars($d->telpon) ?>" required>
                    </div>
                </div>

                <!-- Alamat -->
                <div class="form-group">
                    <label class="col-sm-2" style="padding-top: 7px;">Alamat</label>
                    <div class="col-sm-6">
                        <textarea name="alamat" class="form-control" rows="4" required><?= htmlspecialchars($d->alamat) ?></textarea>
                    </div>
                </div>

                <!-- Google Maps -->
                <div class="form-group">
                    <label class="col-sm-2" style="padding-top: 7px;">Google Maps</label>
                    <div class="col-sm-6">
                        <textarea name="maps" class="form-control" rows="4" required><?= htmlspecialchars($d->maps) ?></textarea>
                    </div>
                </div>

                <!-- Logo -->
                <div class="form-group">
                    <label class="col-sm-2" style="padding-top: 7px;">Logo</label>
                    <div class="col-sm-6">
                        <?php if (!empty($d->logo)) { ?>
                            <img src="../uploads/identitas/<?= htmlspecialchars($d->logo) ?>?v=<?= time(); ?>" 
                            alt="logo" style="max-width:200px; height:auto; border:1px solid #ddd; padding:3px; border-radius:4px; margin-bottom:10px;">
                        <?php } else { ?>
                            <p><i>Tidak ada gambar</i></p>
                        <?php } ?>
                        <input type="file" name="logo" class="form-control" style="margin-top:10px;">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti logo.</small>
                    </div>
                </div>

                <!-- Favicon -->
                <div class="form-group">
                    <label class="col-sm-2" style="padding-top: 7px;">Favicon</label>
                    <div class="col-sm-6">
                        <?php if (!empty($d->favicon)) { ?>
                            <img src="../uploads/identitas/<?= htmlspecialchars ($d->favicon) ?>?v=<?= time(); ?>" alt="favicon"
                                 style="max-width:64px; height:auto; border:1px solid #ddd; padding:3px; border-radius:4px; margin-bottom:10px;">
                        <?php } else { ?>
                            <p><i>Tidak ada gambar</i></p>
                        <?php } ?>
                        <input type="file" name="favicon" class="form-control" style="margin-top:10px;">
                        <small class="text-muted">Kosongkan jika tidak ingin mengganti favicon.</small>
                    </div>
                </div>

                <!-- Tombol Simpan -->
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-6">
                        <button type="submit" name="submit" class="btn btn-success"></i>📥Simpan</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>