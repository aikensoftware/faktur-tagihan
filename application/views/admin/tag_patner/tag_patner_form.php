
	<div class="container">
        <h3 class="page-header"  style="margin-top:0px">Tag_patner <?php echo $button ?></h3>
        <form action="<?php echo $action; ?>" method="post"><input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" style="display: none">
	    <div class="form-group">
            <label for="varchar">Nama <?php echo form_error('nama') ?></label>
            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" value="<?php echo $nama; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Alamat <?php echo form_error('alamat') ?></label>
            <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat" value="<?php echo $alamat; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Telp <?php echo form_error('telp') ?></label>
            <input type="text" class="form-control" name="telp" id="telp" placeholder="Telp" value="<?php echo $telp; ?>" />
        </div>
		<div class="form-group">
            <label for="varchar">Prosentase <?php echo form_error('prosen') ?></label>
            <input type="number" class="form-control" name="prosen" id="prosen" placeholder="prosen" value="<?php echo $prosen; ?>" />
        </div>
	    <input type="hidden" name="id_patner" value="<?php echo $id_patner; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('tag_patner') ?>" class="btn btn-default">Cancel</a>
	</form>

		<br/><br/><br/>
    </div>
	