<?php 

function numchange($a){
		return number_format((float)$a,2,',','.');
}

function formatharga($a){
    return number_format((float)$a,0,',','.');
}

	#ROMAWI
function romawi($a){
	if ($a == 1) {
      return "I";
    }elseif ($a == 2) {
      return "II";
    }elseif ($a == 3) {
       return "III";
    }elseif ($a == 4) {
       return "IV";
    }elseif ($a == 5) {
       return "V";
    }elseif ($a == 6) {
      $nmbln = "Juni";
       return "VI";
    }elseif ($a == 7) {
       return "VII";
    }elseif ($a == 8) {
       return "VIII";
    }elseif ($a == 9) {
       return "IX";
    }elseif ($a == 10) {
       return "X";
    }elseif ($a == 11) {
       return "XI";
    }elseif ($a == 12) {
       return "XII";
    }
}

#namabulan
function namabulan ($a){
	if ($a == 1) {
      return "Januari";
    }elseif ($a == 2) {
      return "Februari";
    }elseif ($a == 3) {
      return "Maret";
    }elseif ($a == 4) {
      return "April";
    }elseif ($a == 5) {
      return "Mei";
    }elseif ($a == 6) {
      return "Juni";
    }elseif ($a == 7) {
      return "Juli";
    }elseif ($a == 8) {
      return "Agustus";
    }elseif ($a == 9) {
      return "September";
    }elseif ($a == 10) {
      return "Oktober";
    }elseif ($a == 11) {
      return "November";
    }elseif ($a == 12) {
      return "Desember";
    }
}

#TERBILANG
function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = penyebut($nilai - 10). " Belas";
		} else if ($nilai < 100) {
			$temp = penyebut($nilai/10)." Puluh". penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " Seratus" . penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = penyebut($nilai/100) . " Ratus" . penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " Seribu" . penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = penyebut($nilai/1000) . " Ribu" . penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = penyebut($nilai/1000000) . " Juta" . penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = penyebut($nilai/1000000000) . " Miliar" . penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = penyebut($nilai/1000000000000) . " Triliun" . penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim(penyebut($nilai));
		} else {
			$hasil = trim(penyebut($nilai));
		}     		
		return $hasil;
	}
?>