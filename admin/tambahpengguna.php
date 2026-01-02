<?php include 'hider.php'; ?>
<div class="container" style="margin-top: 30px;">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title"> 🧑‍💻Tambah Pengguna</h3>
        </div>
        <div class="panel-body">
            <form method="POST" class="form-horizontal" style="margin-top: 15px;">
                
                <!-- Nama Lengkap -->
                <div class="form-group">
                    <label class="col-sm-2" style="padding-top: 7px;">
                        Nama Lengkap
                    </label>
                    <div class="col-sm-6">
                        <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required>
                    </div>
                </div>

                <!-- Username -->
                <div class="form-group">
                    <label class="col-sm-2" style="padding-top: 7px;">
                        Username
                    </label>
                    <div class="col-sm-6">
                        <input type="text" name="user" class="form-control" placeholder="Username" required>
                    </div>
                </div>

                <!-- Level -->
                <div class="form-group">
                    <label class="col-sm-2" style="padding-top: 7px;">
                        Tingkatan
                    </label>
                    <div class="col-sm-4">
                        <select name="level" class="form-control" required>
                            <option value="">>> Jenis Tingkatan <<--</option>
                            <option value="Super Admin">Super Admin</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                </div>

                <!-- Tombol -->
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-6">
                        <button type="submit" name="submit" class="btn btn-success"> 📥Simpan</button>
                        <a href="pengguna.php" class="btn btn-default">◀️Kembali</a>
                    </div>
                </div>
            </form>

            <?php
                include '../koneksi.php';

                if (isset($_POST["submit"])) {
                    $nama  = $_POST['nama'];
                    $user  = $_POST['user'];
                    $level = $_POST['level'];
                    $pass  = '123456';

                    try {

                        // Cek username apakah sudah ada
                        $cek = $pdo->prepare("SELECT username FROM pengguna WHERE username = ?");
                        $cek->execute([$user]);

                        if ($cek->rowCount() > 0) {
                            echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                                    <strong>Maaf!</strong> Username sudah digunakan, coba gunakan yang lain.
                                </div>';
                        } else {

                            $simpan = $pdo->prepare("INSERT INTO pengguna 
                                (nama, username, password, level, created_at, update_at) 
                                VALUES (?, ?, MD5(?), ?, NOW(), NOW())");

                            $simpan->execute([$nama, $user, $pass, $level]);

                            echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
                                    <strong>Berhasil!</strong> Data pengguna berhasil disimpan.
                                </div>';
                        }

                    } catch (PDOException $e) {
                        echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                                <strong>Gagal!</strong> '. $e->getMessage() .'
                            </div>';
                    }
                }
            ?>

        </div>
    </div>
</div>


<?php include 'footer.php'; ?>
