	<div class="container">
		
      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h3>Selamat datang kembali 
			<?php
				$id_patner = $this->session->userdata('DX_id_patner'); 
				if($id_patner > 0){
					$dt_patner = $this->db->query("select * from tag_patner where id_patner = $id_patner ")->row();
					echo $dt_patner->nama;
				}else{
					echo $this->session->userdata('DX_username');  
				}
				
			?>
		</h3>
        <p>Semoga anda hari ini dalam keadaan baik, dan menyenangkan</p>
       
        <p>
          <a class="btn btn-lg btn-primary" href="<?php echo site_url(); ?>/tag_pelanggan" role="button">View Data Pelanggan &raquo;</a>
        </p>
      </div>
	  
	 
		
    </div> <!-- /container -->