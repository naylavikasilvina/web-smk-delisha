<?php
// pastikan koneksi dipanggil
require_once "koneksi.php";

// ambil data identitas sekolah
try{
    $stmt = $pdo->query("SELECT * FROM pengaturan LIMIT 1");
    $d = $stmt->fetch(PDO::FETCH_ASSOC);
} catch(PDOException $e){
    $d = null;
}
?>

<!-- ===== FOOTER ===== -->
<footer style="background:#003f7f; color:white; margin-top:40px; padding:30px 0 15px 0;">
    <div class="container">
        <div class="row">

            <!-- KOLOM 1 -->
            <div class="col-sm-4 text-center">
                <?php if($d && !empty($d['logo'])): ?>
                    <img src="uploads/identitas/<?= htmlspecialchars($d['logo']); ?>" 
                         alt="logo" 
                         style="width:65px; border-radius:50%; margin-bottom:10px;">
                <?php endif; ?>

                <h4 style="margin-top:5px;">
                    <?= $d ? strtoupper(htmlspecialchars($d['nama'])) : "NAMA SEKOLAH"; ?>
                </h4>

                <p style="font-size:13px; opacity:.8;">
                    "Mewujudkan Generasi Siap kerja, Siap Berkarya, Siap Masa Depan"
                </p>
            </div>

            <!-- KOLOM 2 -->
            <div class="col-sm-4 text-center">
                <h5 style="margin-bottom:12px; font-weight:bold;">Navigasi</h5>
                <ul style="list-style:none; padding:0; line-height:26px; font-size:14px;">
                    <li><a href="index.php" style="color:#fff; text-decoration:none;">Beranda</a></li>
                    <li><a href="tentangsekolah.php" style="color:#fff; text-decoration:none;">Tentang Sekolah</a></li>
                    <li><a href="jurusan.php" style="color:#fff; text-decoration:none;">Jurusan</a></li>
                    <li><a href="informasi.php" style="color:#fff; text-decoration:none;">Informasi</a></li>
                    <li><a href="kontak.php" style="color:#fff; text-decoration:none;">Kontak</a></li>
                </ul>
            </div>

            <!-- KOLOM 3 -->
            <div class="col-sm-4 text-center">
                <h5 style="margin-bottom:12px; font-weight:bold;">Kontak</h5>
                <p style="font-size:14px; line-height:22px;">
                    📍 <?= $d ? htmlspecialchars($d['alamat']) : ""; ?><br>
                    📞 <?= $d ? htmlspecialchars($d['telpon']) : ""; ?><br>
                    ✉️ <?= $d ? htmlspecialchars($d ['email']) : ""; ?>
                </p>
            </div>

        </div>

        <hr style="border-color:#555; margin:20px 0;">

        <p class="text-center" style="font-size:13px; opacity:.7;">
            © <?= date('Y'); ?> <?= $d ? htmlspecialchars($d['nama']) : ""; ?> — All Rights Reserved.
        </p>
    </div>
</footer>
<!-- ===== END FOOTER ===== -->
