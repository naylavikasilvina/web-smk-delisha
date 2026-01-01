<?php
    include 'hider.php';
    include '../koneksi.php';

    // PAGINATION
    $limit = 5;
    $page  = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
    $start = ($page - 1) * $limit;

    // SEARCH
    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
    $param = "%" . $keyword . "%";

    // ================= TOTAL DATA ==================
    $stmtTotal = $pdo->prepare("
        SELECT COUNT(*) AS total FROM pengguna
        WHERE nama LIKE ? 
        OR username LIKE ? 
        OR level LIKE ?
    ");
    $stmtTotal->execute([$param, $param, $param]);
    $totalData = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPage = ceil($totalData / $limit);

    // ================= DATA DENGAN LIMIT =================
    $stmt = $pdo->prepare("
        SELECT * FROM pengguna
        WHERE nama LIKE ? 
        OR username LIKE ? 
        OR level LIKE ?
        ORDER BY id DESC
        LIMIT $start, $limit
    ");
    $stmt->execute([$param, $param, $param]);
    $pengguna = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<div class="panel panel-success">
    <div class="panel-heading" style="background:#8bcd50; color:black">
        <h3 class="panel-title">🧑‍💻Data Pengguna</h3>
    </div>

    <div class="panel-body">

        <a href="tambahpengguna.php" class="btn btn-success btn-sm">
            <i class="glyphicon glyphicon-plus"></i> Tambah Pengguna
        </a>

        <hr>

        <!-- FORM SEARCH -->
        <form method="GET" class="form-inline" style="margin-bottom:15px;">
            <input type="text" name="keyword" class="form-control" 
                   placeholder="Cari nama / username / tingkatan"
                   value="<?= $keyword ?>">

            <button type="submit" class="btn btn-primary">🔍Search</button>
            <a href="pengguna.php" class="btn btn-default">🔄Reset</a>
        </form>

        <div class="table-responsive">
            <table id="tabelPengguna" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr class="success">
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Tingkatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $no = $start + 1;
                        if ($totalData > 0) {
                            foreach($pengguna as $p){
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $p['nama']; ?></td>
                        <td><?= $p['username']; ?></td>
                        <td><?= $p['level']; ?></td>
                        <td>
                            <a href="editpengguna.php?id=<?= $p['id']; ?>" class="btn btn-warning btn-sm"> ✏️Edit</a>
                            <a href="ubahpassword.php?id=<?= $p['id']; ?>" class="btn btn-info btn-sm">📝Ubah Password</a>
                            <a href="hapuspengguna.php?id=<?= $p['id']; ?>" class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin anda mau hapus data ini?');"> 🗑️Hapus</a>
                        </td>
                    </tr>
                    <?php
                        }
                    } else {
                        echo '<tr><td colspan="5" class="text-center">Belum ada data pengguna</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <nav aria-label="Page navigation">
            <ul class="pagination">

                <!-- PREV -->
                <?php if ($page > 1) { ?>
                    <li><a href="?page=<?= $page - 1 ?>&keyword=<?= $keyword ?>">&laquo; Prev</a></li>
                <?php } else { ?>
                    <li class="disabled"><a>&laquo; Prev</a></li>
                <?php } ?>

                <!-- NOMOR HALAMAN -->
                <?php for ($i = 1; $i <= $totalPage; $i++) { ?>
                    <li class="<?= ($page == $i) ? 'active' : '' ?>">
                        <a href="?page=<?= $i ?>&keyword=<?= $keyword ?>"><?= $i ?></a>
                    </li>
                <?php } ?>

                <!-- NEXT -->
                <?php if ($page < $totalPage) { ?>
                    <li><a href="?page=<?= $page + 1 ?>&keyword=<?= $keyword ?>">Next &raquo;</a></li>
                <?php } else { ?>
                    <li class="disabled"><a>Next &raquo;</a></li>
                <?php } ?>

            </ul>
        </nav>

    </div>
</div>

<?php include 'footer.php'; ?>
