
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>
		<?php
			$dt_usaha = $this->db->query("select * from tag_usaha");
			if($dt_usaha->num_rows() > 0){
				$r = $dt_usaha->row();
				echo $r->nama;							
			}
		?>
	</title>

	<link href="<?php echo base_url('datatables/datatables.min.css')?>" rel="stylesheet">
	
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
	
	<script src="<?php echo base_url(); ?>assets/js/jQuery.js"></script>
	<script language="javascript">
		var h = jQuery.noConflict();
		h(function() {
			setTimeout(function() {
				h("#message").hide();
			}, 5000);
		});	
    </script>
	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>datatables/datatables.min.css"/>
 
	<script type="text/javascript" src="<?php echo base_url(); ?>datatables/datatables.min.js"></script>

	<!-- color navbar -->
	<style>
		.navbar-default {
		  background-color: #9b59b6;
		  border-color: #8e44ad;
		}
		.navbar-default .navbar-brand {
		  color: #ecf0f1;
		}
		.navbar-default .navbar-brand:hover,
		.navbar-default .navbar-brand:focus {
		  color: #ecdbff;
		}
		.navbar-default .navbar-text {
		  color: #ecf0f1;
		}
		.navbar-default .navbar-nav > li > a {
		  color: #ecf0f1;
		}
		.navbar-default .navbar-nav > li > a:hover,
		.navbar-default .navbar-nav > li > a:focus {
		  color: #ecdbff;
		}
		.navbar-default .navbar-nav > .active > a,
		.navbar-default .navbar-nav > .active > a:hover,
		.navbar-default .navbar-nav > .active > a:focus {
		  color: #ecdbff;
		  background-color: #8e44ad;
		}
		.navbar-default .navbar-nav > .open > a,
		.navbar-default .navbar-nav > .open > a:hover,
		.navbar-default .navbar-nav > .open > a:focus {
		  color: #ecdbff;
		  background-color: #8e44ad;
		}
		.navbar-default .navbar-toggle {
		  border-color: #8e44ad;
		}
		.navbar-default .navbar-toggle:hover,
		.navbar-default .navbar-toggle:focus {
		  background-color: #8e44ad;
		}
		.navbar-default .navbar-toggle .icon-bar {
		  background-color: #ecf0f1;
		}
		.navbar-default .navbar-collapse,
		.navbar-default .navbar-form {
		  border-color: #ecf0f1;
		}
		.navbar-default .navbar-link {
		  color: #ecf0f1;
		}
		.navbar-default .navbar-link:hover {
		  color: #ecdbff;
		}

		@media (max-width: 767px) {
		  .navbar-default .navbar-nav .open .dropdown-menu > li > a {
			color: #ecf0f1;
		  }
		  .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover,
		  .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {
			color: #ecdbff;
		  }
		  .navbar-default .navbar-nav .open .dropdown-menu > .active > a,
		  .navbar-default .navbar-nav .open .dropdown-menu > .active > a:hover,
		  .navbar-default .navbar-nav .open .dropdown-menu > .active > a:focus {
			color: #ecdbff;
			background-color: #8e44ad;
		  }
		}	
	</style>
  
	
	<!-- dropdown -->
	<style>
		 
		.dropdown-menu > li.kopie > a {
			padding-left:5px;
		}
		 
		.dropdown-submenu {
			position:relative;
		}
		.dropdown-submenu>.dropdown-menu {
		   top:0;left:100%;
		   margin-top:-6px;margin-left:-1px;
		   -webkit-border-radius:0 6px 6px 6px;-moz-border-radius:0 6px 6px 6px;border-radius:0 6px 6px 6px;
		 }
		  
		.dropdown-submenu > a:after {
		  border-color: transparent transparent transparent #333;
		  border-style: solid;
		  border-width: 5px 0 5px 5px;
		  content: " ";
		  display: block;
		  float: right;  
		  height: 0;     
		  margin-right: -10px;
		  margin-top: 5px;
		  width: 0;
		}
		 
		.dropdown-submenu:hover>a:after {
			border-left-color:#555;
		 }

		.dropdown-menu > li > a:hover, .dropdown-menu > .active > a:hover {
		  text-decoration: none;
		}  
		  
		@media (max-width: 767px) {

		  .navbar-nav  {
			 display: inline;
		  }
		  .navbar-default .navbar-brand {
			display: inline;
		  }
		  .navbar-default .navbar-toggle .icon-bar {
			background-color: #fff;
		  }
		  .navbar-default .navbar-nav .dropdown-menu > li > a {
			color: red;
			background-color: #ccc;
			border-radius: 4px;
			margin-top: 2px;   
		  }
		   .navbar-default .navbar-nav .open .dropdown-menu > li > a {
			 color: #333;
		   }
		   .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover,
		   .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {
			 background-color: #ccc;
		   }

		   .navbar-nav .open .dropdown-menu {
			 border-bottom: 1px solid white; 
			 border-radius: 0;
		   }
		  .dropdown-menu {
			  padding-left: 10px;
		  }
		  .dropdown-menu .dropdown-menu {
			  padding-left: 20px;
		   }
		   .dropdown-menu .dropdown-menu .dropdown-menu {
			  padding-left: 30px;
		   }
		   li.dropdown.open {
			border: 0px solid red;
		   }

		}
		 
		@media (min-width: 768px) {
		  ul.nav li:hover > ul.dropdown-menu {
			display: block;
		  }
		  #navbar {
			text-align: left;
		  }
		}  
	</style>
	
	<!-- footer -->
	<style>
		
		footer { background-color:#8136a0; min-height:350px; font-family: 'Open Sans', sans-serif; }
		.footerleft { margin-top:50px; padding:0 36px; }
		.logofooter { margin-bottom:10px; font-size:25px; color:#fff; font-weight:700;}

		.footerleft p { color:#fff; font-size:12px !important; font-family: 'Open Sans', sans-serif; margin-bottom:15px;}
		.footerleft p i { width:20px; color:#999;}


		.paddingtop-bottom {  margin-top:50px;}
		.footer-ul { list-style-type:none;  padding-left:0px; margin-left:2px;}
		.footer-ul li { line-height:29px; font-size:12px;}
		.footer-ul li a { color:#a0a3a4; transition: color 0.2s linear 0s, background 0.2s linear 0s; }
		.footer-ul i { margin-right:10px;}
		.footer-ul li a:hover {transition: color 0.2s linear 0s, background 0.2s linear 0s; color:#ff670f; }

		.social:hover {
			 -webkit-transform: scale(1.1);
			 -moz-transform: scale(1.1);
			 -o-transform: scale(1.1);
		 }
		 
		 

		 
		 .icon-ul { list-style-type:none !important; margin:0px; padding:0px;}
		 .icon-ul li { line-height:75px; width:100%; float:left;}
		 .icon { float:left; margin-right:5px;}
		 
		 
		 .copyright { min-height:40px; background-color:#000000;}
		 .copyright p { text-align:left; color:#FFF; padding:10px 0; margin-bottom:0px;}
		 .heading7 { font-size:21px; font-weight:700; color:#d9d6d6; margin-bottom:22px;}
		 .post p { font-size:12px; color:#FFF; line-height:20px;}
		 .post p span { display:block; color:#8f8f8f;}
		 .bottom_ul { list-style-type:none; float:right; margin-bottom:0px;}
		 .bottom_ul li { float:left; line-height:40px;}
		 .bottom_ul li:after { content:"/"; color:#FFF; margin-right:8px; margin-left:8px;}
		 .bottom_ul li a { color:#FFF;  font-size:12px;}
	</style>
 
  </head>

  <body>