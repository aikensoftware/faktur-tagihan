	
	<!--footer start from here-->
	<div class="container">
		<p >Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  '' : '' ?></p>
		<br/>
	</div>
	<script src="<?php echo base_url('assets/bootstrap/js/jquery.min.js')?>"></script>
	<script src="<?php echo base_url('datatables/datatables.min.js')?>"></script>
	 
	 
	<script type="text/javascript">
	 
	var table;
	 
	$(document).ready(function() {
	 
		//datatables
		table = $('#table').DataTable({ 
	 
			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.
	 
			// Load data for the table's content from an Ajax source
			"ajax": {
				"url": "<?php echo site_url('customers/ajax_list')?>",
				"type": "POST"
			},
	 
			//Set column definition initialisation properties.
			"columnDefs": [
			{ 
				"targets": [ 0 ], //first column / numbering column
				"orderable": false, //set not orderable
			},
			],
	 
		});
	 
	});
	</script>
	
	
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