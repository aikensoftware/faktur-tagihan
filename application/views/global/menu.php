<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="<?php echo site_url(); ?>">
			<?php
				$dt_usaha = $this->db->query("select * from tag_usaha");
				if($dt_usaha->num_rows() > 0){
					$r = $dt_usaha->row();
					echo $r->nama;							
				}
			?>
			
		</a>
	</div>
		
	<div class="collapse navbar-collapse" id="navbar-collapse-1">
		<?php
			
			$level = $this->session->userdata('DX_role_id');
			if($level == 2){
				?>
					<ul class="nav navbar-nav">
						<li><a href="<?php echo site_url(); ?>/tag_pelanggan">Data Pelanggan</a></li>
						<li><a href="<?php echo site_url(); ?>/tag_layanan">Data Layanan</a></li>
						<li><a href="<?php echo site_url(); ?>/tag_patner">Data Patner</a></li>
						<li><a href="<?php echo site_url(); ?>/tag_usaha">Nama Usaha</a></li>
					</ul>
				<?php
			}else{
				?>
					<ul class="nav navbar-nav">
						<li><a href="<?php echo site_url(); ?>/tag_pelanggan">Data Pelanggan</a></li>
					</ul>
		<?php		
			}
		?>
		<ul class="nav navbar-nav navbar-right">
			<li><a href="#">Login 
				<?php 
					$id_patner = $this->session->userdata('DX_id_patner'); 
					if($id_patner > 0){
						$dt_patner = $this->db->query("select * from tag_patner where id_patner = $id_patner ")->row();
						echo $dt_patner->nama;
					}else{
						echo 'Admin';
					}
					
				?></a></li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Aksi <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo site_url(); ?>/auth/change_password">Ubah Password</a></li>
						<li><a href="<?php echo site_url(); ?>/auth/logout">LogOut</a></li>
					</ul>
			</li>
		</ul>
	</div><!-- /.navbar-collapse -->
	</div>
</nav>

<div class="container">
	<div style="margin-top: 8px" id="message">
		<?php if($this->session->userdata('message') <> ''){ ?>
			<div class="alert alert-warning alert-dismissible" role="alert" id="pesan">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
			</div>
		<?php } ?>
	</div>
</div>