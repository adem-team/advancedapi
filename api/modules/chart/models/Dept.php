<?php
/**
 * NOTE: Nama Class harus diawali Hurup Besar
 * Server Linux 	: hurup besar/kecil bermasalah -case sensitif-
 * Server Windows 	: hurup besar/kecil tidak bermasalah
 * Author: -ptr.nov-
*/

namespace api\modules\notify\models;
use kartik\builder\Form;
use api\modules\notify\models\Deptsub;
use Yii;

/**
 * DEPARTMENT CLASS  Author: -ptr.nov-
 */
class Dept extends \yii\db\ActiveRecord
{
	/* [1] SOURCE DB */
    public static function getDb()
    {
        /* Author -ptr.nov- :UMUM */
        return \Yii::$app->db_hrm;
    }
	
	/* [2] TABLE SELECT */
    public static function tableName()
    {
        //return '{{dbm000.a0002}}';
		return '{{u0002a}}';
    }

	/* [3] RULE SCENARIO -> DetailView */
    public function rules()
    {
        return [
            [['DEP_ID','DEP_NM'], 'required'],
            [['DEP_ID'], 'string', 'max' => 5],
            [['DEP_NM'], 'string', 'max' => 30],
			[['DEP_DCRP'], 'string'],
			[['SORT'], 'integer'],
			[['CREATED_BY','UPDATED_BY'], 'string', 'max' => 50],
			[['UPDATED_TIME'],'safe'],
        ];
    }

	/* [4] ATRIBUTE LABEL -> DetailView/GridView */
    public function attributeLabels()
    {
        return [
            'DEP_ID' => Yii::t('app', 'Dept.ID'),
            'DEP_NM' => Yii::t('app', 'Name'),
            'DEP_STS' => Yii::t('app', 'Status'),
            'DEP_AVATAR' => Yii::t('app', 'Avatar'),
            'DEP_DCRP' => Yii::t('app', 'Description'),
            'SORT' => Yii::t('app', 'Sorting'),
			'CREATED_BY'=> Yii::t('app','Created'),
			'UPDATED_BY'=> Yii::t('app','Updated'),
			'UPDATED_TIME'=> Yii::t('app','DateTime'),
        ];
    }
	public function getDeptsub()
	{
		return $this->hasMany(Deptsub::className(), ['DEP_ID' => 'DEP_ID']);
	}
	
	public function fields()
	{
		return [
			'DEP_ID',
			'DEP_NM',
			'DEP' => function ($model) {
					return $this->findModelsub($model->DEP_ID); 
			},			
		];
	}
	public function extraFields()
	{
		return ['deptsub'];
	}
	
	public function findModelsub($dept_id){
		//$sub_dept = Deptsub::find()->where(['DEP_ID'=>$dept_id])->one();
		//$this->DEP_SUB_NM = $sub_dept->DEP_SUB_NM;		
		//return $sub_dept;
		 if (($model = Deptsub::find()->where(['DEP_ID'=>$dept_id])->all()) !== null) {
            return $model;
        } else {
           return '';
        }
	}	
	
}


