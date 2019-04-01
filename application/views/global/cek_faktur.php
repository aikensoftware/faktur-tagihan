
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">

    <title>
		<?php
				$dt_usaha = $this->db->query("select * from tag_usaha");
				if($dt_usaha->num_rows() > 0){
					$r = $dt_usaha->row();
					echo $r->nama;							
				}
			?>
	</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/navbar-fixed-top.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="<?php echo base_url(); ?>assets/bootstrap/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<!-- link icon -->
	<link href="<?php echo base_url(); ?>assets/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet">
	
	
<style>
	body, html {
		height: 100%;
		background-repeat: no-repeat;
		background-image: linear-gradient(rgb(104, 145, 162), rgb(12, 97, 33));
	}

	.card-container.card {
		max-width: 350px;
		padding: 40px 40px;
	}

	.btn {
		font-weight: 700;
		height: 36px;
		-moz-user-select: none;
		-webkit-user-select: none;
		user-select: none;
		cursor: default;
	}

	/*
	 * Card component
	 */
	.card {
		background-color: #F7F7F7;
		/* just in case there no content*/
		padding: 20px 25px 30px;
		margin: 0 auto 25px;
		margin-top: 50px;
		/* shadows and rounded borders */
		-moz-border-radius: 2px;
		-webkit-border-radius: 2px;
		border-radius: 2px;
		-moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
		-webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
		box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
	}

	.profile-img-card {
		width: 96px;
		height: 96px;
		margin: 0 auto 10px;
		display: block;
		-moz-border-radius: 50%;
		-webkit-border-radius: 50%;
		border-radius: 50%;
	}

	/*
	 * Form styles
	 */
	.profile-name-card {
		font-size: 16px;
		font-weight: bold;
		text-align: center;
		margin: 10px 0 0;
		min-height: 1em;
	}

	.reauth-email {
		display: block;
		color: #404040;
		line-height: 2;
		margin-bottom: 10px;
		font-size: 14px;
		text-align: center;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
		-moz-box-sizing: border-box;
		-webkit-box-sizing: border-box;
		box-sizing: border-box;
	}

	.form-signin #inputEmail,
	.form-signin #inputPassword {
		direction: ltr;
		height: 44px;
		font-size: 16px;
	}

	.form-signin input[type=email],
	.form-signin input[type=password],
	.form-signin input[type=text],
	.form-signin button {
		width: 100%;
		display: block;
		margin-bottom: 10px;
		z-index: 1;
		position: relative;
		-moz-box-sizing: border-box;
		-webkit-box-sizing: border-box;
		box-sizing: border-box;
	}

	.form-signin .form-control:focus {
		border-color: rgb(104, 145, 162);
		outline: 0;
		-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgb(104, 145, 162);
		box-shadow: inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgb(104, 145, 162);
	}

	.btn.btn-signin {
		/*background-color: #4d90fe; */
		background-color: rgb(104, 145, 162);
		/* background-color: linear-gradient(rgb(104, 145, 162), rgb(12, 97, 33));*/
		padding: 0px;
		font-weight: 700;
		font-size: 14px;
		height: 36px;
		-moz-border-radius: 3px;
		-webkit-border-radius: 3px;
		border-radius: 3px;
		border: none;
		-o-transition: all 0.218s;
		-moz-transition: all 0.218s;
		-webkit-transition: all 0.218s;
		transition: all 0.218s;
	}

	.btn.btn-signin:hover,
	.btn.btn-signin:active,
	.btn.btn-signin:focus {
		background-color: rgb(12, 97, 33);
	}

	.forgot-password {
		color: rgb(104, 145, 162);
	}

	.forgot-password:hover,
	.forgot-password:active,
	.forgot-password:focus{
		color: rgb(12, 97, 33);
	}
</style>
</head>
<body>

<div class="container">
	<div class="card card-container" style="text-align:center;">
	
		<a href="<?php echo site_url(); ?>">
			<img id="profile-img"  src="<?php echo base_url(); ?>gambar/bg/logo.png" />
		</a>
		<p id="profile-name" class="profile-name-card">
		
		<?php
			$dt_usaha = $this->db->query("select * from tag_usaha");
			if($dt_usaha->num_rows() > 0){
				$r = $dt_usaha->row();
				echo $r->nama.'<br/>';							
			}
			
			if(isset($qrcode) && $qrcode <> ''){
				$data = $this->db->query("select a.qrcode, a.id_tagihan, date(a.tanggal) as tanggal, month(a.tanggal) as bulan,
								year(a.tanggal) as tahun, a.no_transaksi, a.total_tagihan, a.pokok, a.pajak,
								b.kode, b.nama, b.alamat
								
								from tag_tagihan as a
								left join tag_pelanggan as b on a.id_pelanggan = b.id_pelanggan
								
								where a.qrcode = '$qrcode'  
								order by a.id_tagihan asc ");
				if($data->num_rows() > 0){
					foreach($data->result() as $b){
						echo '<table class="table table-hover table-bordered  table-striped">
								<tr>
									<td>Nomor Tagihan</td>
									<td>:</td>
									<td>'.$b->no_transaksi.'</td>
								</tr>
								<tr>
									<td>Bulan Tagihan</td>
									<td>:</td>
									<td>'.$this->umum->nama_bulan($b->bulan).' '.$b->tahun.'</td>
								</tr>
								<tr>	
									<td>Pelanggan</td>
									<td>:</td>
									<td>'.$b->nama.'</td>
									
								</tr>	
								<tr>	
									<td>Jumlah Tagihan</td>
									<td>:</td>
									<td>'.$this->umum->format_rupiah($b->pokok + $b->pajak).'</td>
									
								</tr>
								<tr>	
									<td>Status</td>
									<td>:</td>
									<td>Valid</td>
									
								</tr>									
								</table>';
					}
				}
			}
			$qrcode;
			
		?>
		</p>
		
	</div><!-- /card-container -->
</div><!-- /container -->

 <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url(); ?>assets/bootstrap/js/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php echo base_url(); ?>assets/bootstrap/js/jquery.min.js"><\/script>')</script>
    <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo base_url(); ?>assets/bootstrap/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>