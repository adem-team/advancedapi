<?php
namespace common\components;
use yii\base\Component;
use yii\helpers\Html;
use kartik\grid\GridView;
use Yii;

use lukisongroup\esm\models\Barang;
use lukisongroup\esm\models\Distributor;
use lukisongroup\esm\models\Unitbarang;

class esmcode extends Component	{
	
	/* ----------------- Kode Barang ESM */
	public function kdbarang($kdDbtr,$kdType,$kdKategori,$kdUnit)
    {
        $model = new Barang();
		$ck = Barang::find()->select('KD_BARANG')->where('STATUS <> 3')->orderBy(['ID'=>SORT_DESC])->one();
        if(count($ck) == 0){ $nkd = 1; } else { $kd = explode('.',$ck->KD_BARANG); $nkd = $kd[6]+1; }
		$kd = "BRG.".$kdDbtr.".".$kdType.".".$kdKategori.".".$kdUnit.".".str_pad( $nkd, "4", "0", STR_PAD_LEFT );
		
		return $kd;
	}


	/* ----------------- Kode Distributor ESM */
	public function kdDbtr()
    {
		$ck = Distributor::find()->select('KD_DISTRIBUTOR')->where('STATUS <> 3')->orderBy(['ID'=>SORT_DESC])->one();
		if(count($ck) == 0){ $nkd = 1; } else { $kd = explode('.',$ck->KD_DISTRIBUTOR); $nkd = $kd[1]+1; }
		$kd = "DIS.".str_pad( $nkd, "3", "0", STR_PAD_LEFT );

		return $kd;
	}

	/* ----------------- Kode Unit Barang ESM */
	public function kdUnit()
    {
		$ck = Unitbarang::find()->where('STATUS <> 3')->max('KD_UNIT');
		$nw = preg_replace("/[^0-9\']/", '', $ck)+1;
		$nw = str_pad( $nw, "2", "0", STR_PAD_LEFT );
	
		return 'E'.$nw;
	}

	
}
