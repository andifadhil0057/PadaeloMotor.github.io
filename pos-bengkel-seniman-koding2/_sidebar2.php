<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="dist/img/seniman-koding.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
      <span class="brand-text font-weight-light">POS Bengkel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/avatar04.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?= $_SESSION['user_nama']; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <?php if ( $levelLogin !== "kurir" ) { ?>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-desktop"></i> 
              <p>
                 Dashboard
              </p>
            </a>
          </li>

          <li class="nav-header">TRANSAKSI TOKO</li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-shopping-cart"></i>
              <p>
                Penjualan
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
          </li>
          <?php } ?>

          <?php if ( $levelLogin !== "kasir" && $levelLogin !== "kurir" ) { ?>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-shopping-bag"></i>
              <p>
                Pembelian
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
          </li>
          <?php } ?>

          <?php if ( $levelLogin !== "kasir" && $levelLogin !== "kurir" ) { ?>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-exchange"></i>
              <p>
                Transfer Stock
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
          </li>
          <?php } ?>

          <li class="nav-header">SERVIS</li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Transaksi Servis
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-server"></i>
              <p>
                Data Barang Servis
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-cogs"></i>
              <p>
                Teknisi
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
          </li>

          <li class="nav-header">DATA MASTER</li>
          <?php if ( $levelLogin !== "kasir" && $levelLogin !== "kurir" ) { ?>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-university"></i>
              <p>
                Master
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
          </li>
          <?php } ?>

          <li class="nav-header">LAPORAN</li>
          <?php if ( $levelLogin === "super admin" ) { ?>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-line-chart"></i>
              <p>
                Laba Bersih
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
          </li>
          <?php } ?>

          <?php if ( $levelLogin === "kurir" ) { ?>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-table"></i> 
              <p>
                 Data Kurir
              </p>
            </a>
          </li>
          <?php } ?>
          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-file"></i>
              <p>
                Data Laporan Toko
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>

          </li>
          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-file"></i>
              <p>
                Data Laporan Servis
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
          </li>

          <?php if ( $levelLogin === "super admin" || $levelLogin === "admin" ) { ?>
          <li class="nav-header">KONFIGURASI</li>
          <?php if ( $levelLogin === "super admin" ) { ?>
          <li class="nav-item">
            <a href="#!" class="nav-link">
              <i class="nav-icon fa fa-users"></i> 
              <p>
                 Users
              </p>
            </a>
          </li>
          <?php if ( $sessionCabang == 0 ) { ?>
          <li class="nav-item">
            <a href="#!" class="nav-link">
              <i class="nav-icon fa fa-id-card-o"></i> 
              <p>
                 Bengkel
              </p>
            </a>
          </li>
          <?php } ?>
        <?php } ?>
          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-database"></i>
              <p>
                Backup & Restore
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
          </li>
          <?php } ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>