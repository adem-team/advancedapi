<?php
/**
 * NOTE: Nama Class harus diawali Hurup Besar
 * Server Linux 	: hurup besar/kecil bermasalah -case sensitif-
 * Server Windows 	: hurup besar/kecil tidak bermasalah
 * Author: -ptr.nov-
*/

namespace lukisongroup\hrd\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
//use lukisongroup\hrd\models\Jobgrade;
//use lukisongroup\hrd\models\Groupseqmen;
/**
 * Author -ptr.nov- Employe Search
 */
class EmployeSearch extends Employe
{
	 /* [1] PUBLIC ALIAS TABLE*/
	 public $emp;
     public $pen;
	 public $user;
     public $corpOne;
     public $deptOne;
	 //public $jabOne;
     public $sttOne;
	 //public $jobgrade;
	
	/*	[2] RELATED ATTRIBUTE JOIN TABLE*/
	public function attributes()
	{
		/*Author -ptr.nov- add related fields to searchable attributes */
		return array_merge(parent::attributes(), ['corpOne.CORP_NM','deptOne.DEP_NM','deptsub.DEP_SUB_NM','groupfunction.GF_NM','groupseqmen.SEQ_NM','jobgrade.JOBGRADE_NM','sttOne.STS_NM']);
	}
	
	/*	[3] FILTER */
    public function rules()
    {
        return [
            [['EMP_ID', 'EMP_NM','EMP_NM_BLK','EMP_JOIN_DATE','EMP_RESIGN_DATE'], 'safe'],
			[['EMP_ID','EMP_CORP_ID'], 'string', 'max' => 15],
			[['corpOne.CORP_NM','deptOne.DEP_NM','deptsub.DEP_SUB_NM','groupfunction.GF_NM','groupseqmen.SEQ_NM','jobgrade.JOBGRADE_NM','sttOne.STS_NM'], 'safe'],
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
		$query = Employe::find()
						 ->JoinWith('corpOne',true,'LEFT JOIN')
                         ->JoinWith('deptOne',true,'left JOIN')						 
						 ->JoinWith('deptsub',true,'left JOIN')						 
						 ->JoinWith('groupfunction',true,'left JOIN')						 
						 ->JoinWith('groupseqmen',true,'left JOIN')						 
						 ->JoinWith('jobgrade',true,'left JOIN')
						 ->JoinWith('sttOne',true,'left JOIN')						 				  
						  ->Where('a0001.EMP_STS<>3 and a0001.status<>3');
                          //->orWhere('a0001.EMP_STS<>3 and a0001.status<>3');
                          //->orWhere(['a0001.status'=> !3])
                          //->andWhere(['a0001.status'=> !3]);
                          //->andWhere(['a0001.KAR_STS' <>  3]);
						 /* SUB JOIN*/
						//$query->leftJoin(['company'=>$queryCop],'company.CORP_ID=a0001.EMP_CORP_ID');//->orderBy(['company.CORP_ID'=>SORT_ASC]);
						 //->andFilterWhere(['EMP_ID'=>'006']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
		
		/*[5.2] SHORTING */
			/* SORTING CORPORATE Author -ptr.nov-*/
			$dataProvider->sort->attributes['corpOne.CORP_NM'] = [
				'asc' => ['u0001.CORP_NM' => SORT_ASC],
				'desc' => ['u0001.CORP_NM' => SORT_DESC],
			];
			/* SORTING DEPARTMENT Author -ptr.nov-*/
			$dataProvider->sort->attributes['deptOne.DEP_NM'] = [	
				'asc' => ['u0002a.DEP_NM' => SORT_ASC],
				'desc' => ['u0002a.DEP_NM' => SORT_DESC],
			];
			/* SORTING SUB DEPARTMENT Author -ptr.nov-*/
			$dataProvider->sort->attributes['deptsub.DEP_SUB_NM'] = [	
				'asc' => ['u0002b.DEP_SUB_NM' => SORT_ASC],
				'desc' => ['u0002b.DEP_SUB_NM' => SORT_DESC],
			];		
			
			/* SORTING Group Function Author -ptr.nov-*/
			$dataProvider->sort->attributes['groupfunction.GF_NM'] = [
				'asc' => ['u0003a.GF_NM' => SORT_ASC],
				'desc' => ['u0003a.GF_NM' => SORT_DESC],
			];
			
			/* SORTING Group Seqment Author -ptr.nov-*/
			$dataProvider->sort->attributes['groupseqmen.SEQ_NM'] = [
				'asc' => ['u0003b.SEQ_NM' => SORT_ASC],
				'desc' => ['u0003b.SEQ_NM' => SORT_DESC],
			];
			/* SORTING JOBGRADE Author -ptr.nov-*/
			$dataProvider->sort->attributes['jobgrade.JOBGRADE_NM'] = [	
				'asc' => ['u0003c.JOBGRADE_NM' => SORT_ASC],
				'desc' => ['u0003c.JOBGRADE_NM' => SORT_DESC],
			];
			/* SORTING STATUS Author -ptr.nov-*/
			$dataProvider->sort->attributes['sttOne.STS_NM'] = [	
				'asc' => ['b0009.STS_NM' => SORT_ASC],
				'desc' => ['b0009.STS_NM' => SORT_DESC],
			];
			
		/*[5.3] LOAD VALIDATION PARAMS */
			/*LOAD FARM VER 1*/
			$this->load($params);
			if (!$this->validate()) {
				return $dataProvider;
			}
			
			/*LOAD FARM VER 2*/
			// if (!($this->load($params) && $this->validate()))
			//return $dataProvider;		

		/*[5.4] FILTER WHERE LIKE (string/integer)*/
			/* FILTER COLUMN Author -ptr.nov-*/
			 $query->andFilterWhere(['like', 'EMP_ID', $this->EMP_ID])
					->andFilterWhere(['like', 'EMP_NM', $this->EMP_NM])
					->andFilterWhere(['like', 'EMP_NM_BLK', $this->EMP_NM_BLK])
					->andFilterWhere(['like', 'b0009.STS_NM', $this->getAttribute('sttOne.STS_NM')])
					->andFilterWhere(['like', 'u0001.CORP_NM', $this->getAttribute('corpOne.CORP_NM')])
					->andFilterWhere(['like', 'u0002a.DEP_NM', $this->getAttribute('deptOne.DEP_NM')])
					->andFilterWhere(['like', 'u0002b.DEP_SUB_NM', $this->getAttribute('deptsub.DEP_SUB_NM')])
					->andFilterWhere(['like', 'u0003a.GF_NM', $this->getAttribute('groupfunction.GF_NM')])
					->andFilterWhere(['like', 'u0003b.SEQ_NM', $this->getAttribute('groupseqmen.SEQ_NM')])
					->andFilterWhere(['like', 'u0003c.JOBGRADE_NM', $this->getAttribute('jobgrade.JOBGRADE_NM')])					
					->andFilterWhere(['like', 'b0009.STS_NM', $this->getAttribute('sttOne.STS_NM')]);
					
		/*[5.4] FILTER WHERE LIKE (date)*/	
			/* FILTER COLUMN DATE RANGE Author -ptr.nov-*/
			if(isset($this->EMP_JOIN_DATE) && $this->EMP_JOIN_DATE!=''){
				$date_explode = explode("TO", $this->EMP_JOIN_DATE);
				$date1 = trim($date_explode[0]);
				$date2= trim($date_explode[1]);
				$query->andFilterWhere(['between', 'a0001.EMP_JOIN_DATE', $date1,$date2]);
			}
			
        return $dataProvider;
    }
	
	public function searchAll($params)
    {
        $query = Pendidikan::find()->JoinWith('emp',true,'INNER JOIN')
            ->JoinWith('user',true,'INNER JOIN');
            //->Where(['a0001.EMP_ID'=>'LG.0005']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $dataProvider;
    }


    public function search_resign($params)
    {
        /*[5.1] JOIN TABLE */
        $query1 = Employe::find()
            ->JoinWith('corpOne',true,'LEFT JOIN')
            ->JoinWith('deptOne',true,'left JOIN')
			->JoinWith('deptsub',true,'left JOIN')	
            ->JoinWith('groupfunction',true,'left JOIN')						 
			->JoinWith('groupseqmen',true,'left JOIN')						 
			->JoinWith('jobgrade',true,'left JOIN')
			->JoinWith('sttOne',true,'left JOIN')	
            //->where(['a0001.EMP_STS' => 3]);
            ->Where('a0001.EMP_STS=3 and a0001.status<>3');
        /* SUB JOIN*/
        //$query->leftJoin(['company'=>$queryCop],'company.CORP_ID=a0001.EMP_CORP_ID');//->orderBy(['company.CORP_ID'=>SORT_ASC]);
        //->andFilterWhere(['EMP_ID'=>'006']);
        $dataProvider1 = new ActiveDataProvider([
            'query' => $query1,
        ]);

        /*[5.2] SHORTING */
        /* SORTING CORPORATE Author -ptr.nov-*/
        $dataProvider1->sort->attributes['corpOne.CORP_NM'] = [
            'asc' => ['u0001.CORP_NM' => SORT_ASC],
            'desc' => ['u0001.CORP_NM' => SORT_DESC],
        ];
        /* SORTING DEPARTMENT Author -ptr.nov-*/
        $dataProvider1->sort->attributes['deptOne.DEP_NM'] = [
            'asc' => ['deptOne.DEP_NM' => SORT_ASC],
            'desc' => ['deptOne.DEP_NM' => SORT_DESC],
        ];
		
		/* SORTING SUB DEPARTMENT Author -ptr.nov-*/
			$dataProvider1->sort->attributes['deptsub.DEP_SUB_NM'] = [	
				'asc' => ['u0002b.DEP_SUB_NM' => SORT_ASC],
				'desc' => ['u0002b.DEP_SUB_NM' => SORT_DESC],
		];
					
		/* SORTING Group Function Author -ptr.nov-*/
			$dataProvider1->sort->attributes['groupfunction.GF_NM'] = [
				'asc' => ['u0003a.GF_NM' => SORT_ASC],
				'desc' => ['u0003a.GF_NM' => SORT_DESC],
		];
			
		/* SORTING Group Seqment Author -ptr.nov-*/
			$dataProvider1->sort->attributes['groupseqmen.SEQ_NM'] = [
            'asc' => ['u0003b.SEQ_NM' => SORT_ASC],
            'desc' => ['u0003b.SEQ_NM' => SORT_DESC],
        ];
        /* SORTING JOBGRADE Author -ptr.nov-*/
        $dataProvider1->sort->attributes['jobgrade.JOBGRADE_NM'] = [
            'asc' => ['u0003c.JOBGRADE_NM' => SORT_ASC],
            'desc' => ['u0003c.JOBGRADE_NM' => SORT_DESC],
        ];
        /* SORTING STATUS Author -ptr.nov-*/
        $dataProvider1->sort->attributes['sttOne.STS_NM'] = [
            'asc' => ['b0009.STS_NM' => SORT_ASC],
            'desc' => ['b0009.STS_NM' => SORT_DESC],
        ];

        /*[5.3] LOAD VALIDATION PARAMS */
        /*LOAD FARM VER 1*/
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider1;
        }

        /*LOAD FARM VER 2*/
        // if (!($this->load($params) && $this->validate()))
        //return $dataProvider;

        /*[5.4] FILTER WHERE LIKE (string/integer)*/
        /* FILTER COLUMN Author -ptr.nov-*/
        $query1->andFilterWhere(['like', 'EMP_ID', $this->EMP_ID])
            ->andFilterWhere(['like', 'EMP_NM', $this->EMP_NM])
            ->andFilterWhere(['like', 'EMP_NM_BLK', $this->EMP_NM_BLK])
            ->andFilterWhere(['like', 'b0009.STS_NM', $this->getAttribute('sttOne.STS_NM')])
            ->andFilterWhere(['like', 'u0001.CORP_NM', $this->getAttribute('corpOne.CORP_NM')])
            ->andFilterWhere(['like', 'u0002a.DEP_NM', $this->getAttribute('deptOne.DEP_NM')])
			->andFilterWhere(['like', 'u0002b.DEP_SUB_NM', $this->getAttribute('deptsub.DEP_SUB_NM')])
            ->andFilterWhere(['like', 'u0003a.GF_NM', $this->getAttribute('groupfunction.GF_NM')])
			->andFilterWhere(['like', 'u0003b.SEQ_NM', $this->getAttribute('groupseqmen.SEQ_NM')])
			->andFilterWhere(['like', 'u0003c.JOBGRADE_NM', $this->getAttribute('jobgrade.JOBGRADE_NM')])					
			->andFilterWhere(['like', 'b0009.STS_NM', $this->getAttribute('sttOne.STS_NM')]);

        /*[5.4] FILTER WHERE LIKE (date)*/
        /* FILTER COLUMN DATE RANGE Author -ptr.nov-*/
        if(isset($this->EMP_JOIN_DATE) && $this->EMP_JOIN_DATE!=''){
            $date_explode = explode("TO", $this->EMP_JOIN_DATE);
            $date1 = trim($date_explode[0]);
            $date2= trim($date_explode[1]);
            $query1->andFilterWhere(['between', 'a0001.EMP_JOIN_DATE', $date1,$date2]);
        }
        if(isset($this->EMP_RESIGN_DATE) && $this->EMP_RESIGN_DATE!=''){
            $date_explode = explode("TO", $this->EMP_RESIGN_DATE);
            $date3 = trim($date_explode[0]);
            $date4= trim($date_explode[1]);
            $query1->andFilterWhere(['between', 'a0001.EMP_RESIGN_DATE', $date3,$date4]);
        }
        return $dataProvider1;
    }


    public function search_empid($Emp_Id)
    {
        $query = Employe::find()
            ->JoinWith('corpOne',true,'LEFT JOIN')
            ->JoinWith('deptOne',true,'left JOIN')
			->JoinWith('deptsub',true,'left JOIN')	
			->JoinWith('groupfunction',true,'left JOIN')
			->JoinWith('groupseqmen',true,'left JOIN')			
            ->JoinWith('jobgrade',true,'left JOIN')
            ->JoinWith('sttOne',true,'left JOIN')				
            ->where("a0001.EMP_ID='". $Emp_Id . "'");
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $dataProvider;
    }

}
