<?php 
	include '../db.php';
	$cari = $_GET['cari'];
?>
<div class="tabel">
				<table width="100%">
					<tr>
						<th width="30">No</th>
						<th width="170">Lokasi</th>
						<th>Harga/Liter</th>
						<th width="280">Option</th>
					</tr>
				</table>
			</div>
			<div class="overflow">
				<table width="100%">
					<?php 
						$no = 1;
						$query = mysqli_query($db,"SELECT * FROM pengiriman WHERE tempat_kirim LIKE '%$cari%' OR harga_kirim LIKE '%$cari%'");
						$null = mysqli_num_rows($query);
						if ($null == 0) {
							?>
								<tr align="center">
									<td rowspan="3" colspan="3"><h2>Tidak ada data yang cocok</h2></td>
								</tr>
							<?php
						}
						while ($data = mysqli_fetch_assoc($query)) { 
							?>
								<tr>
									<td width="44" align="center"><?=$no?></td>
									<td align="center"><?=$data['tempat_kirim']?></td>
									<td align="center" width="110"><?=$data['harga_kirim']?></td>
									<td width="296" align="center"><a href="form.php?update=1&id=<?php echo($data['id_kirim'])?>">Edit</a> || <a href="del.php?id=<?php echo($data['id_kirim']) ?>" onclick="return confirm('Ingin menghapus data?')" style="background-color: red;">Hapus</a></td>
								</tr>	
					<?php 
							$no++;
							}
					?>
				</table>
			</div>