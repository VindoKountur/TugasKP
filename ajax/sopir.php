<?php 
	include '../db.php';
	$cari = $_GET['cari'];
?>
<div class="tabel">
				<table width="100%">
					<tr>
						<th width="30">No</th>
						<th width="160">Nama</th>
						<th>No Telepon</th>
						<th>Status</th>
						<th width="200">Option</th>
					</tr>
				</table>
			</div>
			<div class="overflow">
				<table width="100%">
	<?php 
		$no = 1;
		$query = mysqli_query($db,"SELECT * FROM driver WHERE nama_driver LIKE '%$cari%' OR no_telp LIKE '%$cari%'");
		$null = mysqli_num_rows($query);
						if ($null == 0) {
							?>
								<tr align="center">
									<td rowspan="4" colspan="4"><h2>Tidak ada data yang cocok</h2></td>
								</tr>
							<?php
						}
						while ($data = mysqli_fetch_assoc($query)) { 
							$status1 = $data['status'];
							if ($status1 !== 'ready') {
								$status = 'Transaksi';
							}else{
								$status = 'Siap';
							}
							?>
								<tr>
									<td width="45" align="center"><?=$no?></td>
									<td width="176" align="center"><?=$data['nama_driver']?></td>
									<td align="center"><?=$data['no_telp']?></td>
									<td width="80" align="center"><?=$status?></td>
									<td width="216" align="center"><a href="form.php?update=1&id=<?php echo($data['id_driver'])?>">Edit</a> || <a href="del.php?id=<?php echo($data['id_driver']) ?>" onclick = "return confirm('Ingin menghapus data?')" style="background-color: red;">Hapus</a></td>
								</tr>
					<?php	$no++;
						}
					?>
</table>
</div>