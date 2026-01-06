<?php include 'hider.php'; ?>

<div class="section" style="margin:40px 0;">
    <div class="container text-center">

   <!-- Judul jurusan -->
        <h3 style="margin-bottom:10px;color:#333;">
           TENTANG SEKOLAH
        </h3>

        <!-- garis kecil dibawah judul -->
        <div style="width:90px;height:3px;background:#e74c3c;margin:10px auto;"></div>

        <!-- Gambar jurusan -->
        <?php if(!empty($d->foto_sekolah)) { ?>
            <img src="uploads/identitas/<?php echo $d->foto_sekolah ?>" 
                 class="img-responsive img-thumbnail" 
                 style="margin:20px auto;max-width:500px;">
        <?php } ?>

        <!-- Deskripsi jurusan -->
        <p style="margin-top:20px;font-size:16px;line-height:1.7;color:#555;text-align:justify;">
            <?php echo nl2br($d->tentang_sekolah) ?>
        </p>


    </div>
</div>

<?php include 'footer.php'; ?>