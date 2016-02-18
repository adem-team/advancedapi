<?php
/**
 * Created by PhpStorm.
 * User: ptr.nov
 * Date: 10/08/15
 * Time: 19:44
 */

namespace common\components;
use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\base\Component;
use Yii\base\Model;
use lukisongroup\models\hrd\Employe;
use lukisongroup\models\hrd\Dept;
use lukisongroup\models\hrd\Jabatan;
use lukisongroup\models\master\Barangumum;

class AmbilkeyComponent extends Component {
   
   public function getKey_Employe($corp_id){
   	 	//$ck = Employe::find(min(['EMP_ID']))->where(['EMP_CORP_ID' => $corp_id])->one();
		$sql1 = "SELECT max(EMP_ID) as EMP_ID FROM a0001 where EMP_ID like '" . $corp_id ."%'";
        $ck= Employe::findBySql($sql1)->one();
		$kd = explode('.',$ck['EMP_ID']);
		//$nkd_test=$kd[2]+1;
		if (count($ck)==0){
			$nkd=1;
		}else{
			$nkd=$kd[2]+1;
		}
		
		$digit=str_pad($nkd,6,"0",STR_PAD_LEFT);
	      
        $emp_id= $corp_id . '.' . date("Y") . '.' .  $digit;

		return $emp_id;
    }	
	
    public function getKey_Department(){
        $sql1 = 'SELECT max(DEP_ID) as DEP_ID FROM departemen';
        $cntdept= Dept::findBySql($sql1)->one();
        $id_cnt_dept=$cntdept->DEP_ID + 1;

        return $id_cnt_dept;
    }
    public function getKey_Jabatan(){
        $sql = 'SELECT max(JAB_ID) as JAB_ID FROM jabatan';
        $cntjabatan= Jabatan::findBySql($sql)->one();
        $id_cnt_jab=$cntjabatan->JAB_ID + 1;

        return $id_cnt_jab;
    }
    public function getKey_finger(){
        $sql = 'SELECT max(NO_URUT) as NO_URUT FROM kar_finger';
        $cntfinger= Finger::findBySql($sql)->one();
        $id_cnt_finger=$cntfinger->NO_URUT + 1;

        return $id_cnt_finger;
    }
	
	 public function getKey_KdBrg($corp_id)
	 {
	 	$ck = Barangumum::find(['max(KD_BARANG) as KD_BARANG'])->where(['KD_CORP' => $corp_id])->one();
		$kd = explode('.',$ck['KD_BARANG']);
		//$nkd_test=$kd[2]+1;
		if (count($ck)==0){
			$nkd=1;
		}else{
			$nkd=$kd[2]+1;
		}
		
		$digit=str_pad($nkd,6,"0",STR_PAD_LEFT);
	      
        $KD_BRG= 'BRG.' . $corp_id . '.' .  $digit;

		return $KD_BRG;
    }
	
	
	
	
} 