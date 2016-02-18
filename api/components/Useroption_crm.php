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
use api\sistem\models\UserloginSearch;

/** 
  * Components User Option layout CRM
  * @author ptrnov  <piter@lukison.com>
  * @since 1.1
*/
class Useroption_crm extends Component{	
	
	/** 		 
	  * Refrensi 		  
	  * Fields 		 		 : 	id,username,auth_key,password_hash,password_reset_token,email,status,created_at,updated_at,EMP_ID  
	  * userprofile->Fields  : 	ID bigint,NM_FIRST,NM_MIDDLE,NM_END,JOIN_DATE,RESIGN_DATE,STS,EMP_IMG,KD_DISTRIBUTOR,KD_SUBDIST,KD_OUTSRC,
	  *							KTP,ALAMAT,ZIP,GENDER,TGL_LAHIR,EMAIL,TLP_HOME,HP,
	  *							CORP_ID,CREATED_BY,CREATED_AT,UPDATED_BY,UPDATED_TIME,STATUS
	  *
	  * Declaration Components
	  * Default: Yii::$app->UserOptcrm->Profile_user();
	  * UseObject: Yii::$app->UserOptcrm->Profile_user()->userprofile->Field;
	  *
	  * Example usage
	  * Example1 : Yii::$app->UserOptcrm->Profile_user()->userprofile->ID;
	  * Example2 : Yii::$app->UserOptcrm->Profile_user()->userprofile->NM_FIRST;
	  * Example3 : Yii::$app->UserOptcrm->Profile_user()->username;
	  * Example4 : $profile=Yii::$app->UserOptcrm->Profile_user();
	  *			   $profile->username;	 	  	Description Parent
	  *			   $profile->userprofile->ID;	  Description hasOne join
	*/
	 public function Profile_user(){
		$UserloginSearch = new UserloginSearch();	
		$ModelProfile = UserloginSearch::findUserAttr(Yii::$app->user->identity->id)->one();
		if (count($ModelProfile)<>0){ /*RECORD TIDAK ADA*/
			//$userid=$ModelProfile->user->id;			
			//$deptid=$ModelProfile->userprofile->CORP_ID;			
			return $ModelProfile;
		} else{
			return 0;
		}	
	 }
	 
	 /** 		 
	  * Refrensi 		  
	  * Fields 				 : id,username,auth_key,password_hash,password_reset_token,email,status,created_at,updated_at,access_token,EMP_ID,avatar,avatarImage  
	  * userprofile->Fields  : 	ID bigint,NM_FIRST,NM_MIDDLE,NM_END,JOIN_DATE,RESIGN_DATE,STS,EMP_IMG,KD_DISTRIBUTOR,KD_SUBDIST,KD_OUTSRC,
	  *							KTP,ALAMAT,ZIP,GENDER,TGL_LAHIR,EMAIL,TLP_HOME,HP,
	  *							CORP_ID,CREATED_BY,CREATED_AT,UPDATED_BY,UPDATED_TIME,STATUS
	  *
	  * mdlpermission->field: ID,USER_ID,MODUL_ID,STATUS,BTN_CREATE,BTN_EDIT,BTN_DELETE,BTN_VIEW
	  *						  BTN_PROCESS1,BTN_PROCESS2,BTN_PROCESS3,BTN_PROCESS4,BTN_PROCESS5,
	  *						  BTN_SIGN1,BTN_SIGN2,BTN_SIGN3,BTN_SIGN4,BTN_SIGN5,
	  *						  CREATED_BY,UPDATED_BY,UPDATED_TIME
	  *
	  * Declaration Components
	  * Default: Yii::$app->getUserOpt->Modul_akses($modul_id);
	  * UseObject: Yii::$app->getUserOpt->Modul_akses(1)->emp->Field;
	  * Yii::$app->getUserOpt->Modul_akses(1)->mdlpermission[0]->ID
	  *
	  * Example usage modul_id=1
	  * Example1 : Yii::$app->getUserOpt->Modul_akses(1)->emp->EMP_ID;
	  * Example2 : Yii::$app->getUserOpt->Modul_akses(1)->emp->EMP_NM;
	  * Example3 : Yii::$app->getUserOpt->Modul_akses(1)->username;
	  * Example3 : Yii::$app->getUserOpt->Modul_akses(1)->mdlpermission[0]->MODUL_ID;
	  * Example4 : $modulakses=Yii::$app->getUserOpt->Modul_akses(1);
	  *			   $modulakses->mdlpermission[0]->MODUL_ID;	  Description hasMany join 
	  *			   $modulakses->username;	  				  Description Parent Model
	  *			   $modulakses->emp->EMP_NM;	  			  Description hasOne join
	*/
	 public function Modul_akses($modul_id){		 
		$UserloginSearch = new UserloginSearch();	
		$ModelAksesModul = UserloginSearch::findModulAcess(Yii::$app->user->identity->id,$modul_id)->one();
		if (count($ModelAksesModul)<>0){ /*RECORD TIDAK ADA*/
			//$userid=$ModelAksesModul->username;			
			//$deptid=$ModelAksesModul->emp->DEP_ID;
			//$deptid=$ModelAksesModul->mdlpermission[0]->MODUL_ID;				
			return $ModelAksesModul;
		} else{
			return 0;
		}	
	 } 
}