
	<div class="container">
        <h3 class="page-header"  style="margin-top:0px">Tag_tagihan <?php echo $button ?></h3>
        <form action="<?php echo $action; ?>" method="post"><input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" style="display: none">
	    <div class="form-group">
            <label for="datetime">Tanggal <?php echo form_error('tanggal') ?></label>
            <input type="text" class="form-control" name="tanggal" id="tanggal" placeholder="Tanggal" value="<?php echo $tanggal; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Periode <?php echo form_error('periode') ?></label>
            <input type="text" class="form-control" name="periode" id="periode" placeholder="Periode" value="<?php echo $periode; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">No Transaksi <?php echo form_error('no_transaksi') ?></label>
            <input type="text" class="form-control" name="no_transaksi" id="no_transaksi" placeholder="No Transaksi" value="<?php echo $no_transaksi; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Id Pelanggan <?php echo form_error('id_pelanggan') ?></label>
            <input type="text" class="form-control" name="id_pelanggan" id="id_pelanggan" placeholder="Id Pelanggan" value="<?php echo $id_pelanggan; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Total Tagihan <?php echo form_error('total_tagihan') ?></label>
            <input type="text" class="form-control" name="total_tagihan" id="total_tagihan" placeholder="Total Tagihan" value="<?php echo $total_tagihan; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Pajak <?php echo form_error('pajak') ?></label>
            <input type="text" class="form-control" name="pajak" id="pajak" placeholder="Pajak" value="<?php echo $pajak; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Status <?php echo form_error('status') ?></label>
            <input type="text" class="form-control" name="status" id="status" placeholder="Status" value="<?php echo $status; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">User Buat <?php echo form_error('user_buat') ?></label>
            <input type="text" class="form-control" name="user_buat" id="user_buat" placeholder="User Buat" value="<?php echo $user_buat; ?>" />
        </div>
	    <input type="hidden" name="id_tagihan" value="<?php echo $id_tagihan; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('tag_tagihan') ?>" class="btn btn-default">Cancel</a>
	</form>

		<br/><br/><br/>
    </div>
	