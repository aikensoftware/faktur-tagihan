
<div class="container">
        <h3 class="page-header" style="margin-top:0px">Tag_layanan List</h3>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('tag_layanan/create'),'Create', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <form action="<?php echo site_url('tag_layanan/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('tag_layanan'); ?>" class="btn btn-default">Reset</a>
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
				<th>Ket</th>
				<th>Harga</th>
				<th>Urutan</th>
				<th>Action</th>
            </tr><?php
            foreach ($tag_layanan_data as $tag_layanan)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $tag_layanan->nama ?></td>
			<td><?php echo $tag_layanan->ket ?></td>
			<td><?php echo $this->umum->format_rupiah($tag_layanan->harga); ?></td>
			<td><?php echo $tag_layanan->urutan ?></td>
			<td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('tag_layanan/read/'.$tag_layanan->id_layanan),'Read',array('class' => 'btn btn-success btn-xs')); 
				echo ' | '; 
				echo anchor(site_url('tag_layanan/update/'.$tag_layanan->id_layanan),'Update',array('class' => 'btn btn-warning btn-xs')); 
				echo ' | '; 
				?>
				  <a href="<?php echo site_url('tag_layanan/delete/'.$tag_layanan->id_layanan); ?>" onclick="javasciprt: return confirm('Are You Sure ?')" class="btn btn-danger btn-xs">Delete</a>
			</td>
		</tr>
                <?php
            }
            ?>
        </table>
        <div class="row">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
		<?php echo anchor(site_url('tag_layanan/excel'), 'Excel', 'class="btn btn-primary"'); ?>
		<?php echo anchor(site_url('tag_layanan/word'), 'Word', 'class="btn btn-primary"'); ?>
	    </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>
		
		<div class="container">
        <h1 style="font-size:20pt">Simple Serverside Datatable Codeigniter</h1>
 
        <h3>Customers Data</h3>
        <br />
        
        <table class="table table-border table-striped table-hover" id="table" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Country</th>
					<th>Aksi</th>
                </tr>
            </thead>
			
            <tbody>
            </tbody>
 
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Country</th>
					<th>Aksi</th>
                </tr>
            </tfoot>
        </table>
    </div>
		
		<br/><br/><br/>
    </div>
	