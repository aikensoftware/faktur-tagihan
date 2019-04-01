
<div class="container">
        <h3 class="page-header" style="margin-top:0px">Tag_tagihan List</h3>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('tag_tagihan/create'),'Create', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <form action="<?php echo site_url('tag_tagihan/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('tag_tagihan'); ?>" class="btn btn-default">Reset</a>
                                    <?php
                                }
                            ?>
                          <button class="btn btn-primary" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <table class="table table-bordered" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Tanggal</th>
		<th>Periode</th>
		<th>No Transaksi</th>
		<th>Id Pelanggan</th>
		<th>Total Tagihan</th>
		<th>Pajak</th>
		<th>Status</th>
		<th>User Buat</th>
		<th>Action</th>
            </tr><?php
            foreach ($tag_tagihan_data as $tag_tagihan)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $tag_tagihan->tanggal ?></td>
			<td><?php echo $tag_tagihan->periode ?></td>
			<td><?php echo $tag_tagihan->no_transaksi ?></td>
			<td><?php echo $tag_tagihan->id_pelanggan ?></td>
			<td><?php echo $tag_tagihan->total_tagihan ?></td>
			<td><?php echo $tag_tagihan->pajak ?></td>
			<td><?php echo $tag_tagihan->status ?></td>
			<td><?php echo $tag_tagihan->user_buat ?></td>
			<td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('tag_tagihan/read/'.$tag_tagihan->id_tagihan),'Read',array('class' => 'btn btn-success btn-xs')); 
				echo ' | '; 
				echo anchor(site_url('tag_tagihan/update/'.$tag_tagihan->id_tagihan),'Update',array('class' => 'btn btn-warning btn-xs')); 
				echo ' | '; 
				?>
				  <a href="<?php echo site_url('tag_tagihan/delete/'.$tag_tagihan->id_tagihan); ?>" onclick="javasciprt: return confirm('Are You Sure ?')" class="btn btn-danger btn-xs">Delete</a>
			</td>
		</tr>
                <?php
            }
            ?>
        </table>
        <div class="row">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
		<?php echo anchor(site_url('tag_tagihan/excel'), 'Excel', 'class="btn btn-primary"'); ?>
		<?php echo anchor(site_url('tag_tagihan/word'), 'Word', 'class="btn btn-primary"'); ?>
	    </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>
		
    </div>
	