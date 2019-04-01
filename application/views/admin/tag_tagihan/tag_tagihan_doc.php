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
        <h2>Tag_tagihan List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Tanggal</th>
		<th>Periode</th>
		<th>No Transaksi</th>
		<th>Id Pelanggan</th>
		<th>Total Tagihan</th>
		<th>Pajak</th>
		<th>Status</th>
		<th>User Buat</th>
		
            </tr><?php
            foreach ($tag_tagihan_data as $tag_tagihan)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $tag_tagihan->tanggal ?></td>
		      <td><?php echo $tag_tagihan->periode ?></td>
		      <td><?php echo $tag_tagihan->no_transaksi ?></td>
		      <td><?php echo $tag_tagihan->id_pelanggan ?></td>
		      <td><?php echo $tag_tagihan->total_tagihan ?></td>
		      <td><?php echo $tag_tagihan->pajak ?></td>
		      <td><?php echo $tag_tagihan->status ?></td>
		      <td><?php echo $tag_tagihan->user_buat ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>