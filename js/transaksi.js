var cari = document.getElementById('cari');
var tabel = document.getElementById('tabel');

cari.addEventListener('keyup', function(){

	//object ajax
	var xhr = new XMLHttpRequest();

	//cek kesiapan ajax
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && xhr.status == 200 ) {
			tabel.innerHTML = xhr.responseText;
		}
	}

	//ekseusi ajax
	xhr.open('GET', '../ajax/transaksi.php?cari=' + cari.value, true);
	xhr.send();
});