<?php
namespace common\components;
use yii\base\Component;
use yii\helpers\Html;
use kartik\grid\GridView;
use Yii;

use lukisongroup\master\models\Barangumum;
use lukisongroup\master\models\Suplier;

class mastercode extends Component	
{
	
	/* ----------------- Kode Barang Umum */
	public function barangumum($kdCorp,$kdType,$kdKategori,$kdUnit)
    {
		$ck = Barangumum::find()->select('KD_BARANG')->where(['KD_CORP' => $kdCorp])->andWhere('STATUS <> 3')->orderBy(['ID'=>SORT_DESC])->one();
		
		if(count($ck) == 0)
            { 
                $nkd = 1; 
            } 
        else 
            { 
                $kd = explode('.',$ck->KD_BARANG); 
                $nkd = $kd[5]+1; 
            }

		$kd = "BRGU.".$kdCorp.".".$kdType.".".$kdKategori.".".$kdUnit.".".str_pad( $nkd, "4", "0", STR_PAD_LEFT );

		return $kd;
	}

	/* ----------------- Kode Supplier */
	public function kdsupplier($crp)
    {
		$ck = Suplier::find()->where('STATUS <> 3')->where(['KD_CORP'=>$crp])->max('KD_SUPPLIER');
		if(count($ck) != 0)
        {
			$nw = explode('.',$ck);
			$nm = $nw[2]+1;
		}
        else
        {
			$nm =1;
		}
		$nn = str_pad($nm, "5", "0", STR_PAD_LEFT );
		$kd = 'SPL.'.$crp."." .$nn;

		return $kd;
	}

	/* ----------------- terbilang */
	public function terbilang($angka)
    {
		$angka = (float)$angka;
        $bilangan = array('','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan','Sepuluh','Sebelas');
        if ($angka < 12) 
        {
            return $bilangan[$angka];
        } 
        else if ($angka < 20) 
        {
            return $bilangan[$angka - 10] . ' Belas';
        } 
        else if ($angka < 100) 
        {
            $hasil_bagi = (int)($angka / 10);
            $hasil_mod = $angka % 10;
            return trim(sprintf('%s Puluh %s', $bilangan[$hasil_bagi], $bilangan[$hasil_mod]));
        } 
        else if ($angka < 200) 
        {
            return sprintf('Seratus %s', $this->terbilang($angka - 100));
        } 
        else if ($angka < 1000) 
        {
            $hasil_bagi = (int)($angka / 100);
            $hasil_mod = $angka % 100;
            return trim(sprintf('%s Ratus %s', $bilangan[$hasil_bagi], $this->terbilang($hasil_mod)));
        } 
        else if ($angka < 2000) 
        {
            return trim(sprintf('Seribu %s', $this->terbilang($angka - 1000)));
        } 
        else if ($angka < 1000000) 
        {
            $hasil_bagi = (int)($angka / 1000); 
            $hasil_mod = $angka % 1000;
            return sprintf('%s Ribu %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod));
        } 
        else if ($angka < 1000000000) 
        {
            $hasil_bagi = (int)($angka / 1000000);
            $hasil_mod = $angka % 1000000;
            return trim(sprintf('%s Juta %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod)));
        } 
        else if ($angka < 1000000000000) 
        {
            $hasil_bagi = (int)($angka / 1000000000);
            $hasil_mod = fmod($angka, 1000000000);
            return trim(sprintf('%s Milyar %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod)));
        } 
        else if ($angka < 1000000000000000) 
        {
            $hasil_bagi = $angka / 1000000000000;
            $hasil_mod = fmod($angka, 1000000000000);
            return trim(sprintf('%s Triliun %s', $this->terbilang($hasil_bagi), $this->terbilang($hasil_mod)));
        } 
        else 
        {
            return 'Data Salah';
        }
	}


	public function rupiah($angka){
		return "Rp ".number_format($angka,0,',','.').' ,-';
	} 

}
