<!-- Sidebar-->
<div class="border-end bg-white" id="sidebar-wrapper">
    <div class="sidebar-heading border-bottom bg-light d-flex justify-content-center p-3">
        <img src="http://hayuq.gemjeeh.my.id/hh.png" alt="hotel" width="100px">
    </div>
    <div class="list-group list-group-flush">
        <a href="../kamar/kamar-view.php" class="list-group-item list-group-item-action list-group-item-light p-2 py-3 <?php
                                                                                                                        if ($_SESSION["current_page"] == "Kamar") {
                                                                                                                            echo "active";
                                                                                                                        } else {
                                                                                                                            echo "inactive";
                                                                                                                        }
                                                                                                                        ?>">
            <span><i class="fa fa-door-closed"></i> Kamar</span>
        </a>
        <a href="../pemesanan/pemesanan-view.php" class="list-group-item list-group-item-action list-group-item-light p-2 py-3 <?php
                                                                                                                                if ($_SESSION["current_page"] == "Pemesanan") {
                                                                                                                                    echo "active";
                                                                                                                                } else {
                                                                                                                                    echo "inactive";
                                                                                                                                }
                                                                                                                                ?>">
            <span><i class="fa fa-receipt"></i> Pemesanan</span>
        </a>
        <a href="../pembayaran/pembayaran-view.php" class="list-group-item list-group-item-action list-group-item-light p-2 py-3 <?php
                                                                                                                                    if ($_SESSION["current_page"] == "Pembayaran") {
                                                                                                                                        echo "active";
                                                                                                                                    } else {
                                                                                                                                        echo "inactive";
                                                                                                                                    }
                                                                                                                                    ?>">
            <span><i class="fa fa-file-invoice-dollar"></i> Pembayaran</span>
        </a>
        <a href="../pelanggan/pelanggan-view.php" class="list-group-item list-group-item-action list-group-item-light p-2 py-3 <?php
                                                                                                                                if ($_SESSION["current_page"] == "Pelanggan") {
                                                                                                                                    echo "active";
                                                                                                                                } else {
                                                                                                                                    echo "inactive";
                                                                                                                                }
                                                                                                                                ?>">
            <span><i class="fa fa-users"></i> Pelanggan</span>
        </a>
        <a href="../petugas/petugas-view.php" class="list-group-item list-group-item-action list-group-item-light p-2 py-3 <?php
                                                                                                                            if ($_SESSION["current_page"] == "Petugas") {
                                                                                                                                echo "active";
                                                                                                                            } else {
                                                                                                                                echo "inactive";
                                                                                                                            }
                                                                                                                            ?>">
            <span><i class="fa fa-id-card"></i> Petugas</span>
        </a>
        <a href="../logout.php" class="list-group-item list-group-item-action list-group-item-light p-2 py-3" id="logout">
            <span><i class="fa fa-right-from-bracket"></i> Logout</span>
        </a>
    </div>
</div>