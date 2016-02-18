<?php
/**
 * NOTE: Nama Class harus diawali Hurup Besar
 * Server Linux 	: hurup besar/kecil bermasalah -case sensitif-
 * Server Windows 	: hurup besar/kecil tidak bermasalah
 * Author: -ptr.nov-
*/

namespace api\modules\notify\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Author -ptr.nov- Employe Search
 */
class DeptSearch extends Dept
{
	
	public function attributes()
	{
		//Author -ptr.nov- add related fields to searchable attributes 
		return array_merge(parent::attributes(), ['deptsub.DEP_SUB_NM']);
	}
	
	/*	[1] FILTER */
    public function rules()
    {
        return [
            [['DEP_ID'], 'string', 'max' => 5],
            [['DEP_NM'], 'string', 'max' => 30],
			[['SORT'], 'integer'],
			[['DEP_DCRP','deptsub.DEP_SUB_NM'], 'string'],
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
		$query = Dept::find()
							->JoinWith('deptsub',true,'LEFT JOIN');
							//->Where('u0002a.DEP_STS<>3');
        $dataProvider_Dept = new ActiveDataProvider([
            'query' => $query,
        ]);
		
		/*[5.3] LOAD VALIDATION PARAMS */
			/*LOAD FARM VER 1*/
			$this->load($params);
			if (!$this->validate()) {
				return $dataProvider_Dept;
			}

		/*[5.4] FILTER WHERE LIKE (string/integer)*/
			/* FILTER COLUMN Author -ptr.nov-*/
			 $query->andFilterWhere(['like', 'DEP_ID', $this->DEP_ID])
					->andFilterWhere(['like', 'DEP_NM', $this->DEP_NM]);			
        return $dataProvider_Dept;
    }
}
