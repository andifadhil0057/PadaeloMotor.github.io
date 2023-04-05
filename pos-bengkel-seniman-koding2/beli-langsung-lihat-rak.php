<?php 
  include 'aksi/halau.php'; 
  include 'aksi/functions.php';
  $id = $_POST['id'];

  $barang = query("SELECT * FROM barang WHERE barang_id = $id")[0];
?>


	   <div class="form-group">
        <label for="barang_lokasi_rak">Posisi</label>
        <input type="teks" name="barang_lokasi_rak" class="form-control" id="barang_lokasi_rak" value="<?= $barang['barang_lokasi_rak']; ?>" readonly>
    </div>
