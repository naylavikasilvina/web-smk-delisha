<?php 
    include 'hider.php';
    include '../koneksi.php';

    // Cek id valid
    if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
        echo "<script>window.location='pengguna.php'</script>";
        exit;
    }
    $id = $_GET['id'];

    // Ambil data pengguna
    $stmt = $pdo->prepare("SELECT * FROM pengguna WHERE id = ?");
    $stmt->execute([$id]);
    $p = $stmt->fetch(PDO::FETCH_OBJ);

    if(!$p){
        echo "<script>window.location='pengguna.php'</script>";
        exit;
    }
?>

<div class="container" style="margin-top: 30px;">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title"> 🧑‍💻Edit Pengguna</h3>
        </div>

        <div class="panel-body">
            <form method="POST" class="form-horizontal" style="margin-top: 15px;">
                
                <!-- Nama Lengkap -->
                <div class="form-group">
                    <label class="col-sm-2" style="padding-top: 7px;">
                        Nama Lengkap
                    </label>
                    <div class="col-sm-6">
                        <input type="text" name="nama" class="form-control" 
                               value="<?= $p->nama ?>" required>
                    </div>
                </div>

                <!-- Username -->
                <div class="form-group">
                    <label class="col-sm-2" style="padding-top: 7px;">
                        Username
                    </label>
                    <div class="col-sm-6">
                        <input type="text" name="user" class="form-control" 
                               value="<?= $p->username ?>" required>
                    </div>
                </div>

                <!-- Level -->
                <div class="form-group">
                    <label class="col-sm-2" style="padding-top: 7px;">
                        Tingkatan
                    </label>
                    <div class="col-sm-4">
                        <select name="level" class="form-control" required>
                            <option value="">-- Jenis Tingkatan --</option>
                            <option value="Super Admin" <?= ($p->level == 'Super Admin') ? 'selected' : '' ?>>
                                Super Admin
                            </option>
                            <option value="Admin" <?= ($p->level == 'Admin') ? 'selected' : '' ?>>
                                Admin
                            </option>
                        </select>
                    </div>
                </div>

                <!-- Tombol -->
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-6">
                        <button type="submit" name="submit" class="btn btn-info">📝Edit</button>
                        <a href="pengguna.php" class="btn btn-default">◀️Kembali</a>
                    </div>
                </div>
            </form>

            <?php
                if (isset($_POST["submit"])) {

                    $nama  = $_POST['nama'];
                    $user  = $_POST['user'];
                    $level = $_POST['level'];

                    $update = $pdo->prepare("
                        UPDATE pengguna SET 
                            nama = ?, 
                            username = ?, 
                            level = ?, 
                            update_at = NOW()
                        WHERE id = ?
                    ");

                    if($update->execute([$nama, $user, $level, $id])){
                        echo '<div class="alert alert-success" style="margin-top:15px;">
                                <strong>Berhasil!</strong> Data pengguna berhasil diperbarui.
                            </div>';
                    } else {
                        echo '<div class="alert alert-danger" style="margin-top:15px;">
                                <strong>Gagal!</strong> Data pengguna gagal diperbarui.
                            </div>';
                    }
                }
            ?>

        </div>
    </div>
</div>

<?php include 'footer.php'; ?>