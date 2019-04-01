
<div class="container">
        <h3 class="page-header" style="margin-top:0px">Tag_patner List</h3>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('tag_patner/create'),'Create', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <form action="<?php echo site_url('tag_patner/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('tag_patner'); ?>" class="btn btn-default">Reset</a>
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
		<th>Kode</th>
		<th>Nama</th>
		<th>Alamat</th>
		<th>Telp</th>
		<th>Prosen</th>
		<th>Action</th>
		<th>Reset Password</th>
            </tr><?php
            foreach ($tag_patner_data as $tag_patner)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $tag_patner->kode ?></td>
			<td><?php echo $tag_patner->nama ?></td>
			<td><?php echo $tag_patner->alamat ?></td>
			<td><?php echo $tag_patner->telp ?></td>
			<td style="text-align:right;"><?php echo $tag_patner->prosen ?>%</td>
			<td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('tag_patner/read/'.$tag_patner->id_patner),'Read',array('class' => 'btn btn-success btn-xs')); 
				echo ' | '; 
				echo anchor(site_url('tag_patner/update/'.$tag_patner->id_patner),'Update',array('class' => 'btn btn-warning btn-xs')); 
				echo ' | '; 
				?>
				  <a href="<?php echo site_url('tag_patner/delete/'.$tag_patner->id_patner); ?>" onclick="javasciprt: return confirm('Are You Sure ?')" class="btn btn-danger btn-xs">Delete</a>
				
			</td>
			<td>
				  <a href="<?php echo site_url('tag_patner/reset_password/'.$tag_patner->id_patner); ?>" onclick="javasciprt: return confirm('Are You Sure Reset To 1234567 ?')" class="btn btn-warning btn-xs">Reset</a>
			</td>
		</tr>
                <?php
            }
            ?>
        </table>
        <div class="row">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
		<?php echo anchor(site_url('tag_patner/excel'), 'Excel', 'class="btn btn-primary"'); ?>
		<?php echo anchor(site_url('tag_patner/word'), 'Word', 'class="btn btn-primary"'); ?>
	    </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>
		
		<br/><br/><br/>
    </div>
	