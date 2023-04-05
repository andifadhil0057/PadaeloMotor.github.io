<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="bo" class="brand-link">
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
          
          <li class="nav-item">
            <a href="bo" class="nav-link">
              <i class="nav-icon fa fa-desktop"></i> 
              <p>
                 Dashboard
              </p>
            </a>
          </li>

          <?php if ( $levelLogin === "kurir" ) { ?>
          <li class="nav-item">
            <a href="kurir-data" class="nav-link">
              <i class="nav-icon fa fa-table"></i> 
              <p>
                 Data Kurir
              </p>
            </a>
          </li>
          <?php } ?>

        <?php if ( $levelLogin !== "mekanik" && $levelLogin !== "kurir" ) { ?>
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
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="beli-langsung" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kasir</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="penjualan" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Invoice Penjualan</p>
                </a>
              </li>
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Piutang
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="piutang" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Belum Lunas</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="piutang-lunas" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Lunas</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>

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
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="transaksi-pembelian" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Transaksi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pembelian" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Invoice Pembelian</p>
                </a>
              </li>
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Hutang
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="hutang" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Belum Lunas</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="hutang-lunas" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Lunas</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
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
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="transfer-stock-cabang" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Transaksi</p>
                </a>
              </li>
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Data Transfer Stock
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="transfer-stock-cabang-masuk" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Masuk</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="transfer-stock-cabang-keluar" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Keluar</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <?php } ?>
        <?php } ?>

        <?php if ( $levelLogin !== "kurir" ) { ?>
          <li class="nav-header">SERVIS</li>
          <?php if ( $levelLogin !== "mekanik" && $levelLogin !== "kurir" ) { ?>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Transaksi Servis
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="servis-penerimaan-barang?kendaraan=<?= base64_encode(0) ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Penerimaan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="servis-pengembalian-barang" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pengembalian</p>
                </a>
              </li>
            </ul>
          </li>
          <?php } ?>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-server"></i>
              <p>
                Data Kendaraan Servis
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="servis-data-barang" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kendaraan Servis</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="servis-data-berkala" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sevis Berkala</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="servis-data-barang-garansi" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Servis Garansi</p>
                </a>
              </li>
            </ul>
          </li>
          <?php if ( $levelLogin !== "mekanik" ) { ?>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-cogs"></i>
              <p>
                Mekanik
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="servis-dikerjakan" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Servis Dikerjakan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="servis-dikerjakan-masih-garansi" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Servis Garansi Komplain</p>
                </a>
              </li>
            </ul>
          </li>
          <?php } ?>

          <li class="nav-header">DATA MASTER</li>
          <?php if ( $levelLogin !== "mekanik" ) { ?>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-university"></i>
              <p>
                Master
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Data Barang
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <?php if ( $levelLogin !== "mekanik" && $levelLogin !== "kasir" ) { ?>
                  <li class="nav-item">
                    <a href="kategori" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Kategori</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="satuan" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Satuan</p>
                    </a>
                  </li>
                  <?php } ?>
                  <li class="nav-item">
                    <a href="barang" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Barang</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="customer" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Customer</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="kendaraan" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kendaraan</p>
                </a>
              </li>
              <?php if ( $levelLogin !== "mekanik" && $levelLogin !== "kasir" ) { ?>
              <li class="nav-item">
                <a href="supplier" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Supplier</p>
                </a>
              </li>
              <?php } ?>
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Data Servis
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="kategori-servis" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Kategori Servis</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="servis" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Price List Servis</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <?php } ?>
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
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="laba-bersih-data" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Operasional</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="laba-bersih-laporan" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Laporan Laba Bersih</p>
                </a>
              </li>
            </ul>
          </li>
          <?php } ?>
          
          <?php if ( $levelLogin !== "mekanik" ) { ?>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-file"></i>
              <p>
                Data Laporan Toko
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
            
            <ul class="nav nav-treeview">
              <?php if ( $levelLogin !== "kasir" && $levelLogin !== "kurir" ) { ?>
              <li class="nav-item">
                <a href="laporan-kasir" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kasir</p>
                </a>
              </li>
              <?php } ?>

              <?php if ( $levelLogin === "kasir" ) { ?>
              <li class="nav-item">
                <a href="laporan-kasir-pribadi" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kasir Pribadi</p>
                </a>
              </li>
              <?php } ?>

              <?php if ( $levelLogin === "kurir" ) { ?>
              <li class="nav-item">
                <a href="laporan-kurir-pribadi" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kurir Pribadi</p>
                </a>
              </li>
              <?php } ?>

              <?php if ( $levelLogin !== "kurir" ) { ?>
              <li class="nav-item">
                <a href="laporan-customer" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Customer</p>
                </a>
              </li>
              <?php } ?>

              <?php if ( $levelLogin !== "kasir" && $levelLogin !== "kurir" ) { ?>
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Penjualan
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="periode" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Per Periode</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="laporan-produk" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Per Produk</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="edit-transaksi" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Retur</p>
                    </a>
                  </li>
                </ul>
              </li>
              
              <li class="nav-item">
                <a href="laporan-supplier" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Supplier</p>
                </a>
              </li>

              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Pembelian
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="periode-pembelian" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Per Periode</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="laporan-produk-pembelian" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Per Produk</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="edit-transaksi-pembelian" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Retur</p>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="nav-item">
                <a href="terlaris" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Terlaris</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="stok" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Stok</p>
                </a>
              </li>
            </ul>
            <?php } ?>
          </li>
          <?php } ?>
          
          <?php if ( $levelLogin !== "kasir" && $levelLogin !== "kurir" ) { ?>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-file"></i>
              <p>
                Data Laporan Servis
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right"></span>
              </p>
            </a>
            
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Pribadi
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="laporan-teknisi-pribadi-profit" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Profit</p>
                    </a>
                  </li>
                </ul>
              </li>
              <?php if ( $levelLogin !== "mekanik" ) { ?>
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Mekanik
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="laporan-teknisi-profit" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Profit</p>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="nav-item">
                <a href="laporan-servis-periode" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Profit Servis Periode</p>
                </a>
              </li>
              <?php } ?>
              <li class="nav-item">
                <a href="laporan-servis-status?status=<?= base64_encode(4); ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Status Servis</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="laporan-status-servis-periode" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Status Periode</p>
                </a>
              </li>
            </ul>
          </li>
          <?php } ?>

      <?php if ( $levelLogin === "super admin" || $levelLogin === "admin" ) { ?>
          <li class="nav-header">KONFIGURASI</li>
        <?php if ( $levelLogin === "super admin" ) { ?>
          <li class="nav-item">
            <a href="user-type" class="nav-link">
              <i class="nav-icon fa fa-users"></i> 
              <p>
                 Users
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="toko" class="nav-link">
              <i class="nav-icon fa fa-id-card-o"></i> 
              <p>
                 Bengkel
              </p>
            </a>
          </li>
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
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="backup" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Backup</p>
                </a>
              </li>
              <?php if ( $sessionCabang < 1 ) { ?>
              <li class="nav-item">
                <a href="restore" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Restore</p>
                </a>
              </li>
              <?php } ?>
            </ul>
          </li>
      <?php } ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>