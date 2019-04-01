<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            .word-table {
                border:1px solid black !important; 
                border-collapse: collapse !important;
                width: 100%;
            }
            .word-table tr th, .word-table tr td{
                border:1px solid black !important; 
                padding: 5px 10px;
            }
        </style>
    </head>
    <body>
        <h2>Tag_usaha List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Nama</th>
		<th>Alamat</th>
		<th>Telp</th>
		<th>Ket</th>
		
            </tr><?php
            foreach ($tag_usaha_data as $tag_usaha)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $tag_usaha->nama ?></td>
		      <td><?php echo $tag_usaha->alamat ?></td>
		      <td><?php echo $tag_usaha->telp ?></td>
		      <td><?php echo $tag_usaha->ket ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>