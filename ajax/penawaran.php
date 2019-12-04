<?php 

include '../db.php';
include '../fungsi.php';
$cari = $_GET['cari'];
?>
<div class="tabel">
<table width="100%">
<?php  
	$query = mysqli_query($db,"SELECT * FROM penawaran WHERE nama_p LIKE '%$cari%' OR harga_pokok LIKE '%$cari%' OR total LIKE '%$cari%' ORDER BY tanggal_buat DESC");
	$no = 1;
?>
		<tr>
			<th width="30">No</th>
			<th>Nama Perusahaan</th>
			<th width="180">Tanggal Buat</th>
			<th width="180">Harga Pokok (Rp)</th>
			<th width="180">Harga Jual (Rp)</th>
			<th width="180">Option</th>
		</tr>
	</table>
</div>
<div class="overflow">
	<table width="100%">
		<?php  
			$null = mysqli_num_rows($query);
			if ($null == 0) {
				?>
				<tr align="center">
					<td colspan="10" rowspan="6"><h2>Tidak ada data yang cocok</h2></td>
				</tr>
				<?php
			} else {
		?>
		<?php while ($data = mysqli_fetch_assoc($query)) { ?>
					<tr>
						<td align="center" width="46"><?=$no?></td>
						<td><?= $data['nama_p']?></td>
						<td align="center" width="196"><?= $data['tanggal_buat']?></td>
						<td align="center" width="196"><?= formatharga($data['harga_pokok'])?></td>
						<td align="center" width="196"><?= formatharga($data['total'])?></td>
						<td align="center" width="196"><a href="../print/penawaran.php?idsp=<?php echo($data['id_sp']) ?>" target="_blank" style="background-color: #6666ff ;">Cetak</a> || <a href="formubah.php?idsp=<?php echo($data['id_sp']) ?>" style="color: black; background-color: white; border: .5px solid black;">Ubah</a> || <a href="del.php?idsp=<?php echo($data['id_sp']) ?>" onclick="return confirm('Ingin menghapus data ini?')" style="color: white;">Hapus</a></td>
					</tr>
				<?php $no++; ?>
		<?php } } ?>
		
	</table>
</div>