<?php 
  include '_header-artibut.php';
  $id = $_POST['id'];
?>
	
	<input type="hidden" name="dst_id" value="<?= $id; ?>">
	<div class="form-group">
        <label for="dst_teknisi_id">Nama Mekanik</label>
        <select class="form-control select2bs4 pilihan-marketplace" required="" name="dst_teknisi_id">
          <option selected="selected" value="">-- Pilih --</option>
            <?php  
              $mekanik = query("SELECT * FROM user WHERE user_level = 'mekanik' && user_status = 1  && user_cabang = $sessionCabang ");
            ?>
            <?php foreach ( $mekanik as $row ) : ?>
              <option value="<?= $row['user_id'] ?>"><?= $row['user_nama'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>


<script>
  $(function () {

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  });
</script>