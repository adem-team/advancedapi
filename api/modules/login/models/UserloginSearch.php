<?php
/**
 * NOTE: Nama Class harus diawali Hurup Besar
 * Server Linux 	: hurup besar/kecil bermasalah -case sensitif-
 * Server Windows 	: hurup besar/kecil tidak bermasalah
 * Author: -ptr.nov-
*/

namespace lukisongroup\models\system\user;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/** 
  * Option user, employe, modul, permission
  * @author ptrnov  <piter@lukison.com>
  * @since 1.1
*/
class UserloginSearch extends Userlogin
{
	public $emp;
	//public $mdlakses;
	/*	[1] FILTER */
    public function rules()
    {
        return [
            [['username','EMP_ID','email'], 'string'],
            [['email','avatar','avatarImage'], 'string'],
			[['id','status','created_at','updated_at'],'integer'],
        ];
    }
	
	/*	[4] SCNARIO */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }
	
	/*	[5] SEARCH dataProvider -> SHOW GRIDVIEW */
    public function search($params)
    {	
		/*[5.1] JOIN TABLE */
		$query = Userlogin::find();
        $dataProvider_Userlogin = new ActiveDataProvider([
            'query' => $query,
        ]);
		
		/*[5.3] LOAD VALIDATION PARAMS */
			/*LOAD FARM VER 1*/
			$this->load($params);
			if (!$this->validate()) {
				return $dataProvider_Userlogin;
			}

		/*[5.4] FILTER WHERE LIKE (string/integer)*/
			/* FILTER COLUMN Author -ptr.nov-*/
			 $query->andFilterWhere(['like', 'username', $this->username]);			
        return $dataProvider_Userlogin;
    }
	
	public function attributes()
	{
		/*Author -ptr.nov- add related fields to searchable attributes */
		return array_merge(parent::attributes(), ['emp.EMP_IMG','emp.EMP_NM','emp.EMP_NM_BLK','Mdlpermission.ID']);
	}
	
	/** 
	  * findUserAttr User and Employe
	  * @author ptrnov  <piter@lukison.com>
	  * @since 1.1
	*/
	public function findUserAttr($id)
    {
		$model = Userlogin::find()->select('*')
				->joinWith('emp',true,'LEFT JOIN')
				->Where(['dbm001.user.id' => $id]);
				//->one();
		if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	/** 
	  * findUserAttr User and Employe and Modul Permission
	  * @author ptrnov  <piter@lukison.com>	
	  * @since 1.1
	*/
	public function findModulAcess($id,$modul_id)
    {
		$model = Userlogin::find()->select('*')
					->joinWith('emp',true,'LEFT JOIN')
					->joinWith('mdlpermission',true,'LEFT JOIN')
					->Where('dbm001.user.id='. $id .' AND modul_permission.MODUL_ID=' .$modul_id);				
		if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
