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

class Ro_generateComponent extends Component {   
   
   /* - Permission Request Order */
   public function getRo_permission($empId){   	 
	 $dt = Employe::find()->where(['EMP_ID'=>$empId])->one(); //$empId = Yii::$app->user->identity->EMP_ID;
	 
	 
	 return $KD_BRG;
   }	
   
   /* - Generate Code Request Order */
   public function getRo_code($corp_id){
	   
   	 return $KD_BRG;
   }
} 