<?php 
  include 'aksi/halau.php'; 
  include 'aksi/functions.php';
  $id = $_POST['id'];

  $keranjang = query("SELECT * FROM keranjang WHERE keranjang_id = $id")[0];

  $bik = $keranjang['barang_id'];
  $stockParent = mysqli_query( $conn, "select barang_stock, barang_option_sn from barang where barang_id = '".$bik."'");
  $brg = mysqli_fetch_array($stockParent); 
  $tb_brg = $brg['barang_stock'];
  $tb_bos = $brg['barang_option_sn'];
?>


	<input type="hidden" name="keranjang_id" value="<?= $id; ?>">
	<div class="form-group">
        <label for="keranjang_harga">Edit Harga</label>
        <input type="number" name="keranjang_harga" class="form-control" id="keranjang_harga" value="<?= $keranjang['keranjang_harga']; ?>" required>
    </div>

    <?php if ( $tb_bos < 1 ) : ?>
    <div class="form-group">
        <label for="keranjang_harga">Edit QTY</label>
        <input type="number" min="1" name="keranjang_qty" class="form-control" value="<?= $keranjang['keranjang_qty'] ?>" required> 
    </div>
    <?php else : ?>
      <input type="hidden" name="keranjang_qty" value="<?= $keranjang['keranjang_qty'] ?>">
    <?php endif; ?>
    <input type="hidden" name="stock_brg" value="<?= $tb_brg; ?>">