<?php 
	include '../db.php';
	include '../fungsi.php';
	$cari = $_GET['cari'];
?>
<div class="tabel">
	<table width="100%" cellpadding="3" style="text-align: center;">
		<tr>
			<th width="25">No</th>
			<th>Nama Perusahaan</th>
			<th width="120">Tanggal Pesan</th>
			<th width="140">Jumlah Pesanan (L)</th>
			<th width="120">Harga Jual (Rp)</th>
			<th width="120">Surat Jalan</th>
			<th width="120">Invoice</th>
			<th width="200">Option</th>
		</tr>
	</table>
</div>
<div class="overflow">
	<table width="100%" cellpadding="3" style="text-align: center;">
<?php
	$no = 1; 
	$query = mysqli_query($db,"SELECT * FROM transaksi AS tr INNER JOIN perusahaan AS p ON tr.nama_p = p.id_perusahaan WHERE p.nama_perusahaan LIKE '%$cari%' OR tr.quantity LIKE '%$cari%' OR tr.harga_jual LIKE '%$cari%' ORDER BY tr.tanggal_pesan DESC");
	$null = mysqli_num_rows($query);
						if ($null == 0) {
							?>
								<tr align="center">
									<td rowspan="8" colspan="8"><h2>Tidak ada data yang cocok</h2></td>
								</tr>
							<?php
						}
						while ($data = mysqli_fetch_assoc($query)) { ?>
								<tr>
									<td width="35"><?= $no ?></td>
									<td align="left"><?= $data['nama_perusahaan'] ?></td>
									<td width="128"><?= $data['tanggal_pesan']?></td>
									<td width="148"><?= formatharga($data['quantity'])?></td>
									<td width="128"><?php echo(formatharga($data['harga_jual']))?></td>
									<td width="128">
										<?php if (!empty($data['suratjalan'])) {
											echo "$data[suratjalan]";
										} else { ?>
												<a href="../print/suratjalan.php?id=<?php echo($data['id_transaksi']) ?>" target="_blank" class="btn" onclick="document.location.href='index.php'">Buat</a>
										<?php } ?>
									</td>
									<td width="128">
										<?php if (!empty($data['invoice'])) {
											echo "$data[invoice]";
										} else { ?>
											<a href="../print/invoice.php?id=<?php echo($data['id_transaksi']) ?>" target="_blank" class="btn" onclick="document.location.href='index.php'">Buat</a>
										<?php } ?>
									</td>
									<td width="216"><a href='detail.php?id=<?php echo($data['id_transaksi'])?>'>Detail</a></td>
								</tr>			
					<?php	$no++; } ?>
				</table>
			</div>