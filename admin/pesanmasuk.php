<?php 
include 'hider.php'; 
include '../koneksi.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
$notif = "";

// ========== PROSES HAPUS ==========
if (isset($_GET['hapus'])) {
    $id_hapus = (int) $_GET['hapus'];

    try {
        $stmt = $pdo->prepare("DELETE FROM pesan_kontak WHERE id = :id");
        $stmt->execute([':id' => $id_hapus]);

        if ($stmt->rowCount() > 0) {
            $notif = 'Pesan berhasil dihapus.';
        } else {
            $notif = 'Pesan tidak ditemukan atau gagal dihapus.';
        }
    } catch(PDOException $e){
        $notif = "Error: " . $e->getMessage();
    }
}

// ========== AMBIL DATA PESAN ==========
try {
    $stmt = $pdo->query("SELECT * FROM pesan_kontak ORDER BY tanggal DESC");
    $pesan = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e){
    $pesan = [];
}
?>

<div class="container" style="margin-top:25px;">

    <h3 class="text-center" style="margin-bottom:25px;">
        PESAN MASUK
    </h3>

    <?php if (!empty($notif)) : ?>
        <div class="alert alert-info">
            <?= htmlspecialchars($notif); ?>
        </div>
    <?php endif; ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>📩Pesan Masuk</strong>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr class="text-center">
                            <th style="width:50px;">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Pesan</th>
                            <th style="width:150px;">Tanggal</th>
                            <th style="width:120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($pesan && count($pesan) > 0) : 
                            $no = 1;
                            foreach ($pesan as $row) :
                                $preview = substr($row['pesan'], 0, 80);
                                if (strlen($row['pesan']) > 80) {
                                    $preview .= '...';
                                }
                        ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['nama']); ?></td>
                            <td><?= htmlspecialchars($row['email']); ?></td>
                            <td><?= nl2br(htmlspecialchars($preview)); ?></td>
                            <td class="text-center">
                                <?= date('d-m-Y H:i', strtotime($row['tanggal'])); ?>
                            </td>
                            <td class="text-center">
                                <a href="pesandetail.php?id=<?= $row['id']; ?>" 
                                   class="btn btn-info btn-xs">🧾Detail
                                </a>

                                <a href="pesanmasuk.php?hapus=<?= $row['id']; ?>" 
                                   class="btn btn-danger btn-xs"
                                   onclick="return confirm('Yakin ingin menghapus pesan ini?');">🗑️Hapus
                                </a>
                            </td>
                        </tr>
                        <?php 
                            endforeach;
                        else : ?>
                        <tr>
                            <td colspan="6" class="text-center">
                                Belum ada pesan yang masuk.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
