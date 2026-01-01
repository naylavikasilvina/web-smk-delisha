<?php 
include 'hider.php'; 

$nama   = $_SESSION['unama'] ?? 'Admin';
$level  = $_SESSION['ulevel'] ?? 'admin'; // misal: superadmin / admin
?>

<body class="dashboard">

<div class="container" style="margin-top:20px;">

    <?php if(strtolower($level) == 'superadmin' || strtolower($level) == 'super admin'){ ?>
        
        <h3>Halo, <?= htmlspecialchars($nama) ?> 👋</h3>
        <p>Selamat datang di <strong>Panel Super Admin</strong>.  
        Di halaman ini Anda dapat mengelola pengguna dan data pengguna lannya.</p>

        <div class="row">

            <!-- KELOLA PENGGUNA -->
            <div class="col-md-4">
                <div class="panel panel-default shadow-box">
                    <div class="panel-body">
                        <h4>👤 Kelola Pengguna</h4>
                        <p>Tambahkan, edit, atau hapus data pengguna.</p>
                        <a href="pengguna.php" class="btn btn-success btn-block">
                            Kelola Pengguna
                        </a>
                    </div>
                </div>
            </div>

        </div>

    <?php } else { ?>

        <h3>Halo, <?= htmlspecialchars($nama) ?> 👋</h3>
        <p>Selamat datang di panel admin <?= $d ? htmlspecialchars($d->nama) : 'Sekolah' ?>.</p>
        <p>Melalui halaman ini Anda dapat mengelola data sekolah,
        memperbarui informasi, dan memastikan website tetap up to date 💻🎯.</p>

        <div class="row">

            <!-- JURUSAN -->
            <div class="col-md-4">
                <div class="panel panel-default shadow-box">
                    <div class="panel-body">
                        <h4>📚 Program Keahlian / Jurusan</h4>
                        <p>Kelola daftar jurusan yang ada di sekolah.</p>
                        <a href="jurusan.php" class="btn btn-success btn-block">
                            Kelola Jurusan
                        </a>
                    </div>
                </div>
            </div>

            <!-- FASILITAS -->
            <div class="col-md-4">
                <div class="panel panel-default shadow-box">
                    <div class="panel-body">
                        <h4>🏫 Fasilitas Sekolah</h4>
                        <p>Atur data fasilitas sekolah yang ditampilkan.</p>
                        <a href="fasilitas.php" class="btn btn-success btn-block">
                            Kelola Fasilitas
                        </a>
                    </div>
                </div>
            </div>

            <!-- GALERI -->
            <div class="col-md-4">
                <div class="panel panel-default shadow-box">
                    <div class="panel-body">
                        <h4>🖼️ Galeri Sekolah</h4>
                        <p>Tambah / edit foto kegiatan sekolah.</p>
                        <a href="galeri.php" class="btn btn-success btn-block">
                            Kelola Galeri
                        </a>
                    </div>
                </div>
            </div>

            <!-- EKSKUL -->
            <div class="col-md-4">
                <div class="panel panel-default shadow-box">
                    <div class="panel-body">
                        <h4>🎯 Ekstrakurikuler</h4>
                        <p>Kelola data kegiatan ekstrakurikuler.</p>
                        <a href="ekskul.php" class="btn btn-success btn-block">
                            Kelola Ekskul
                        </a>
                    </div>
                </div>
            </div>

            <!-- INFORMASI -->
            <div class="col-md-4">
                <div class="panel panel-default shadow-box">
                    <div class="panel-body">
                        <h4>📢 Informasi Sekolah</h4>
                        <p>Kelola pengumuman & berita sekolah.</p>
                        <a href="informasi.php" class="btn btn-success btn-block">
                            Kelola Informasi
                        </a>
                    </div>
                </div>
            </div>

        </div>

    <?php } ?>

</div>

<style>
.shadow-box{
    border-radius:10px;
    box-shadow:0 3px 10px rgba(0,0,0,0.12);
    margin-bottom:20px;
}
.panel-body h4{
    margin-top:0;
    font-weight:bold;
}
</style>

<?php include 'footer.php'; ?>
