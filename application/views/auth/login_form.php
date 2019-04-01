
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
<?php
$username = array(
	'name'	=> 'username',
	'id'	=> 'username',
	'size'	=> 30,
	'value' => set_value('username')
);

$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 30
);

$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember'),
	'style' => 'margin:0;padding:0'
);

$confirmation_code = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8
);

?>

<div class="container">
	<div class="card card-container" style="text-align:center;">
	
		<img id="profile-img"  src="<?php echo base_url(); ?>gambar/bg/logo.png" />
		<p id="profile-name" class="profile-name-card">Login <br/>
		<?php
			$dt_usaha = $this->db->query("select * from tag_usaha");
			if($dt_usaha->num_rows() > 0){
				$r = $dt_usaha->row();
				echo $r->nama;							
			}
		?>
		</p>
		<?php echo form_open($this->uri->uri_string())?>
		<br>
		<?php echo $this->dx_auth->get_auth_error(); ?>
			<span id="reauth-email" class="reauth-email"></span>
			<input type="text" id="inputEmail" class="form-control" name="username" placeholder="Email / Username " required autofocus>
			<input type="password" id="inputPassword" class="form-control" name="password" placeholder="Password" required>
			<div id="remember" class="checkbox">
				<label>
					<input type="checkbox" value="remember-me"> Remember me
				</label>
			</div>
			<button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Sign in</button>
		<?php echo form_close()?>
		<?php echo anchor($this->dx_auth->forgot_password_uri, 'Forgot password',array('class' => 'forgot-password'));?> 
		
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