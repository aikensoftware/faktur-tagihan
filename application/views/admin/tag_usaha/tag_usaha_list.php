
<div class="container">
        <h3 class="page-header" style="margin-top:0px">Nama Perusahaan</h3>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php //echo anchor(site_url('tag_usaha/create'),'Create', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <form action="<?php echo site_url('tag_usaha/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('tag_usaha'); ?>" class="btn btn-default">Reset</a>
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
		<th>Nama</th>
		<th>Alamat</th>
		<th>Telp</th>
		<th>Ket</th>
		<th>Action</th>
            </tr><?php
            foreach ($tag_usaha_data as $tag_usaha)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $tag_usaha->nama ?></td>
			<td><?php echo $tag_usaha->alamat ?></td>
			<td><?php echo $tag_usaha->telp ?></td>
			<td><?php echo $tag_usaha->ket ?></td>
			<td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('tag_usaha/read/'.$tag_usaha->id_usaha),'Read',array('class' => 'btn btn-success btn-xs')); 
				echo ' | '; 
				echo anchor(site_url('tag_usaha/update/'.$tag_usaha->id_usaha),'Update',array('class' => 'btn btn-warning btn-xs')); 
				echo ' | '; 
				?>
				  <a href="<?php echo site_url('tag_usaha/delete/'.$tag_usaha->id_usaha); ?>" onclick="javasciprt: return confirm('Are You Sure ?')" class="btn btn-danger btn-xs">Delete</a>
			</td>
		</tr>
                <?php
            }
            ?>
        </table>
        <div class="row">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
		<?php echo anchor(site_url('tag_usaha/excel'), 'Excel', 'class="btn btn-primary"'); ?>
		<?php echo anchor(site_url('tag_usaha/word'), 'Word', 'class="btn btn-primary"'); ?>
	    </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>
		
		<br/><br/><br/>
    </div>
	