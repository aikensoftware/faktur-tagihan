
	<div class="container">
        <h3 class="page-header"  style="margin-top:0px">Tag_layanan Read</h3>
        <table class="table">
	    <tr><td>Nama</td><td><?php echo $nama; ?></td></tr>
	    <tr><td>Ket</td><td><?php echo $ket; ?></td></tr>
		<tr><td>Harga</td><td><?php echo $this->umum->format_rupiah($harga); ?></td></tr>
	    <tr><td>Urutan</td><td><?php echo $urutan; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('tag_layanan') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>

			<br/><br/><br/>
        </div>
