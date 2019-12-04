<?php 
	include '../db.php';
	$cari = $_GET['cari'];
?>
<div class="tabel">
	<table width="100%">
		<tr>
			<th width="25">No</th>
			<th width="200">Nama Perusahaan</th>
			<th width="130">NPWP</th>
			<th width="100">No Telepon</th>
			<th width="86">PBBKB (%)</th>
			<th width="69">OAT (Rp)</th>
			<th width="98">Alamat Kirim</th>
			<th>Alamat Lengkap</th>
			<th width="110">Option</th>
		</tr>
	</table>
</div>
<div class="overflow">
	<table width="100%">
<?php 
	$no = 1;
	$query = mysqli_query($db,"SELECT * FROM perusahaan WHERE nama_perusahaan LIKE '%$cari%' OR npwp LIKE '%$cari%'");
	$null = mysqli_num_rows($query);
if ($null == 0) {
	?>
		<tr align="center">
			<td rowspan="9" colspan="9"><h2>Tidak ada data yang cocok</h2></td>
		</tr>
	<?php
}
while ($data = mysqli_fetch_assoc($query)) { 
$jalan = $data['jalan'];
$kabkota = $data['kabkota'];
$provinsi = $data['provinsi'];
$alamat = "$jalan".", "."$kabkota".", "."$provinsi";
	?>
		<tr>
			<td align="center" width="38"><?=$no?></td>
			<td width="216"><?=$data['nama_perusahaan']?></td>
			<td width="146" align="center"><?=$data['npwp']?></td>
			<td width="116" align="center"><?=$data['no_telp']?></td>
			<td width="93" align="center"><?=$data['pbbkb']?></td>
			<td width="85" align="center"><?=$data['oat']?></td>
			<td width="126" align="center"><?=$data['ship_to']?></td>
			<td><?= $alamat ?></td>
			<td width="126" align="center"><a href='form.php?update=1&id=<?php echo($data['id_perusahaan'])?>'>Ubah</a> || <a href="del.php?id=<?php echo($data['id_perusahaan'])?>" onclick="return confirm('Ingin menghapus data?')" style="background-color: red;">Hapus</a></td>
					</tr>
		<?php
				$no++;
			}
		?>
	</table>
</div>