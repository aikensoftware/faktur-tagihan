
	<div class="container">
        <h3 class="page-header"  style="margin-top:0px">Tag_layanan <?php echo $button ?></h3>
        <form action="<?php echo $action; ?>" method="post"><input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" style="display: none">
	    <div class="form-group">
            <label for="varchar">Nama <?php echo form_error('nama') ?></label>
            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" value="<?php echo $nama; ?>" />
        </div>
		<div class="form-group">
            <label for="varchar">Harga <?php echo form_error('harga') ?></label>
            <input type="text" class="form-control" name="harga" id="harga" placeholder="harga" value="<?php echo $harga; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Ket <?php echo form_error('ket') ?></label>
            <input type="text" class="form-control" name="ket" id="ket" placeholder="Ket" value="<?php echo $ket; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Urutan <?php echo form_error('urutan') ?></label>
            <input type="text" class="form-control" name="urutan" id="urutan" placeholder="Urutan" value="<?php echo $urutan; ?>" />
        </div>
	    <input type="hidden" name="id_layanan" value="<?php echo $id_layanan; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('tag_layanan') ?>" class="btn btn-default">Cancel</a>
	</form>

		<br/><br/><br/>
    </div>
	