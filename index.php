<?php
// kalau ini halaman publik, cukup pakai koneksi saja
require_once "koneksi.php";
include "hider.php";

// ==== AMBIL DATA IDENTITAS SEKOLAH ====
try{
    $stmt = $pdo->query("SELECT * FROM pengaturan LIMIT 1");
    $d = $stmt->fetch(PDO::FETCH_ASSOC);
} catch(PDOException $e){
    $d = null;
}
?>

<!-- HERO -->
<div class="container" style="margin-top:20px;"> 
    <div class="hero-section" 
        style="
            position:relative;
            background: url('uploads/identitas/<?= $d ? htmlspecialchars($d['foto_sekolah']) : '' ?>') center 20%/cover no-repeat;
            height: 350px;
            border-radius: 10px;
            overflow:hidden;
        ">

        <!-- 🔥 IKLAN GARIS DI BAGIAN BAWAH -->
        <div style="
            position:absolute;
            bottom:0;
            left:0;
            width:100%;
            background:rgba(0,0,0,0.65);
            padding:8px 0;
            white-space:nowrap;
            overflow:hidden;
        ">
            <span style="
                display:inline-block;
                padding-left:100%;
                font-size:18px;
                font-weight:bold;
                color:white;
                animation:jalan 20s linear infinite;
            ">
                🎉 Selamat Datang di Website 
                <?= $d ? strtoupper(htmlspecialchars($d['nama'])) : "SEKOLAH" ?> 👋 —
                Website resmi untuk informasi akademik, kegiatan sekolah, dan layanan publik 📢
            </span>
        </div>

    </div>
</div>

<style>
@keyframes jalan{
    from{ transform:translateX(0); }
    to{ transform:translateX(-100%); }
}
</style>


<!-- ===== SAMBUTAN KEPSEK ===== -->
<div class="container" style="margin-top:30px; margin-bottom:40px;">
    <div class="row">

        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-body text-center">

                    <?php if($d && $d['foto_kepsek']): ?>
                    <img src="uploads/identitas/<?= htmlspecialchars($d['foto_kepsek']) ?>" 
                         alt="Foto Kepala Sekolah"
                         class="img-responsive img-circle center-block"
                         style="max-width:150px; margin-bottom:10px;">
                    <?php endif; ?>

                    <h4 style="margin-top:10px; font-weight:bold;">
                        <?= $d ? htmlspecialchars($d['nama_kepsek']) : "-" ?>
                    </h4>
                    <p style="margin:0; color:#666;">Kepala Sekolah</p>
                </div>
            </div>
        </div>

        <div class="col-sm-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3 style="margin-top:0;">Sambutan Kepala Sekolah</h3>
                    <div style="text-align:justify; line-height:1.8;">
                        <?= $d ? $d['kata_sambutan'] : "-" ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- ===== JURUSAN ===== -->
<div class="section" style="margin:40px 0;">
    <div class="container text-center">

        <h3 style="margin-bottom:5px;">🎓Kejuruan</h3>
        <div style="width:80px;height:3px;background:#e74c3c;margin:10px auto 25px auto;"></div>

        <div class="row">
        <?php
        $stmt = $pdo->query("SELECT * FROM jurusan ORDER BY id ASC");
        $jurusan = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($jurusan):
            foreach($jurusan as $j):
        ?>

        <a href="detail-jurusan.php?id=<?= $j['id']; ?>" style="text-decoration:none; color:inherit;">
            <div class="col-sm-3 col-xs-6" style="margin-bottom:20px;">
                <div class="thumbnail" style="border-radius:6px;">
                    <div class="thumbnail-img" style="height:150px; overflow:hidden;">
                        <img src="uploads/jurusan/<?= htmlspecialchars($j['gambar']); ?>" 
                             class="img-responsive">
                    </div>
                    <div class="caption">
                        <h4 style="font-size:14px; font-weight:bold;">
                            <?= htmlspecialchars($j['nama']); ?>
                        </h4>
                    </div>
                </div>
            </div>
        </a>

        <?php endforeach; else: ?>
            <div class="col-xs-12">
                <p>Belum ada data jurusan.</p>
            </div>
        <?php endif; ?>
        </div>

    </div>
</div>

<!-- ===== Fasilitas ===== -->
<div class="section" style="margin:40px 0;">
    <div class="container text-center">

        <h3 style="margin-bottom:5px;">🛠️Fasilitas Sekolah</h3>
        <div style="width:80px;height:3px;background:#e74c3c;margin:10px auto 25px auto;"></div>

        <div class="row">
        <?php
        $stmt = $pdo->query("SELECT * FROM fasilitas ORDER BY id ASC");
        $fasilitas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($fasilitas):
            foreach($fasilitas as $j):
        ?>

            <div class="col-sm-3 col-xs-6" style="margin-bottom:20px;">
                <div class="thumbnail" style="border-radius:6px;">
                    <div class="thumbnail-img" style="height:150px; overflow:hidden;">
                        <img src="uploads/fasilitas/<?= htmlspecialchars($j['foto']); ?>" 
                             class="img-responsive">
                    </div>
                    <div class="caption">
                        <h4 style="font-size:14px; font-weight:bold;">
                            <?= htmlspecialchars($j['keterangan']); ?>
                        </h4>
                    </div>
                </div>
            </div>
        </a>

        <?php endforeach; else: ?>
            <div class="col-xs-12">
                <p>Belum ada informasi.</p>
            </div>
        <?php endif; ?>
        </div>

    </div>
</div>

<!-- ===== INFORMASI ===== -->
<div class="section" style="margin:40px 0;">
    <div class="container">

        <h3 class="text-center">📢Informasi terbaru</h3>
        <div style="width:100px;height:3px;background:#3498db;margin:10px auto 25px auto;"></div>

        <div class="row">

        <?php
        $stmt = $pdo->query("SELECT * FROM informasi ORDER BY id DESC LIMIT 6");
        $info = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($info):
            foreach($info as $i):
        ?>

        <div class="col-sm-4 col-xs-12" style="margin-bottom:25px;">
            <div class="thumbnail">
                <div style="height:160px;overflow:hidden;">
                    <img src="uploads/informasi/<?= htmlspecialchars($i['gambar']); ?>" 
                         class="img-responsive">
                </div>

                <div class="caption" style="display:flex; flex-direction:column; height:180px;">
                    <div>
                        <h4 style="font-size:16px; font-weight:bold;">
                            <?= htmlspecialchars($i['judul']); ?>
                        </h4>

                        <small style="color:gray;">
                            📅 <?= date('d M Y', strtotime($i['created_at'])); ?>
                        </small>

                        <p style="margin-top:10px; text-align:justify;">
                            <?= substr(strip_tags($i['keterangan']), 0, 90); ?>...
                        </p>
                    </div>

                    <a href="detail-informasi.php?id=<?= $i['id']; ?>" 
                       class="btn btn-primary btn-sm btn-block"
                       style="margin-top:auto;">
                        Baca Selengkapnya
                    </a>
                </div>
            </div>
        </div>

        <?php endforeach; else: ?>
            <div class="col-xs-12 text-center">
                <p>Belum ada informasi terbaru.</p>
            </div>
        <?php endif; ?>
        </div>
    </div>
</div>

<script src="bootstrap/js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>

<?php include "footer.php"; ?>
