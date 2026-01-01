<div class="footer" style="background:#b7f3bf; padding:15px 0; margin-top:30px;">
    <div class="container text-center" style="color:#064d1f; font-weight:bold;">
        Copyright &copy; 2025 - <?= $d->nama ?>
    </div>
</div>


<script src="../bootstrap/js/jquery.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../DataTables/datatables.min.js"></script>

<script>
    $(document).ready(function() {

        // Cek Bootstrap Dropdown
        if (typeof $.fn.dropdown === 'function')  { $('.dropdown-toggle').dropdown(); }

        // Cek DataTables
        if ($.fn.DataTable) {
            $('#tabelpengguna').DataTable({
                language: {
                    infoEmpty: "Tidak Ada Data yang Tersedia",
                    search: "Cari :",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Selanjutnya"
                    }
                }
            });
        } else {
            console.error('DataTables belum terload');
        }

    });
</script>
</body>
</html>
