<?php
/**
 * NOTE: Nama Class harus diawali Hurup Besar
 * Server Linux 	: hurup besar/kecil bermasalah -case sensitif-
 * Server Windows 	: hurup besar/kecil tidak bermasalah
 * Author: -ptr.nov-
*/

namespace api\modules\master\models;
use Yii;
use yii\web\UploadedFile;

/**
 * EMPLOYE CLASS  Author: -ptr.nov-
 */
class Employee extends \yii\db\ActiveRecord
{
	public $upload_file;
	
	/* [1] SOURCE DB */
    public static function getDb()
	{
		/* Author -ptr.nov- : HRD */
		return \Yii::$app->db2;  
	}
	
	/* [2] TABLE SELECT */
	public static function tableName()
    {
        return '{{dbm002.a0001}}';
    }   
    
	/* [3] RULE SCENARIO -> DetailView */
    public function rules()
    {
        return [
            // [['EMP_NM','EMP_KTP','EMP_ALAMAT'], 'required'],
            [['EMP_ID','EMP_ZIP','EMP_CORP_ID'], 'string', 'max' => 20],
            [['EMP_NM','EMP_NM_BLK','EMP_IMG','EMP_KTP','GRP_NM'], 'string', 'max' => 20], 
			[['DEP_ID','JOBGRADE_ID'], 'string', 'max' => 5], 
			[['DEP_SUB_ID'], 'string', 'max' => 6], 
			[['GF_ID','EMP_STS','SEQ_ID'], 'integer'],
			[['EMP_JOIN_DATE','EMP_TGL_LAHIR','EMP_RESIGN_DATE'], 'safe'],
			[['EMP_JOIN_DATE','EMP_TGL_LAHIR','EMP_RESIGN_DATE'], 'date','format' => 'yyyy-mm-dd'], 
			[['EMP_ALAMAT'],  'filter', 'filter' => function($value) {
                    return trim(htmlentities(strip_tags($value), ENT_QUOTES, 'UTF-8'));}],
			[['EMP_TLP','EMP_HP'], 'string', 'max' => 15], 
			[['EMP_GENDER'], 'string', 'max' => 6], 
			[['EMP_EMAIL'], 'string', 'max' => 30],  			
		    
            [['EMP_IMG'], 'string', 'max' => 50],    
			[['upload_file'], 'file', 'skipOnEmpty' => true,'extensions'=>'jpg,png', 'mimeTypes'=>'image/jpeg, image/png',],
			[['CREATED_BY','UPDATED_BY'], 'string', 'max' => 50],
			[['SIGSVGBASE64','SIGSVGBASE30','SIGPASSWORD'], 'safe'], 
			//[['UPDATED_TIME'], 'date'], errot message bool false
        ];
    }


	/* [4] ATRIBUTE LABEL  -> DetailView/GridView */
    public function attributeLabels()
    {
        return [
			// Employe Identity - Author: -ptr.nov-
			'EMP_IMG' => Yii::t('app', 'Pic'),
            'EMP_ID' => Yii::t('app', 'Employee.ID'),
            'EMP_NM' => Yii::t('app', 'First.Name'),
            'EMP_NM_BLK' => Yii::t('app', 'Last.Name'),
            
			
			// Employe Coorporation - Author: -ptr.nov-
			'EMP_CORP_ID' => Yii::t('app', 'Corp.ID'),
            'DEP_ID' => Yii::t('app', 'Department'),
			'EMP_GENDER' => Yii::t('app', 'Jenis Kelamin'),
			'EMP_STS' => Yii::t('app', 'Status'),
			'JOBGRADE_ID' => Yii::t('app', 'Jabatan'),
			'EMP_JOIN_DATE' => Yii::t('app', 'Join.Date'),
			'EMP_RESIGN_DATE' => Yii::t('app', 'Resign.Date'),		
						
			//Employe Profile - Author: -ptr.nov-
            'EMP_KTP' => Yii::t('app', 'No.KTP'),
            'EMP_ALAMAT' => Yii::t('app', 'Alamat'),
			'EMP_ZIP' => Yii::t('app', 'Postal Code'),
            'EMP_TLP' => Yii::t('app', 'Telphone'),
            'EMP_HP' => Yii::t('app', 'Handphone'),
			'EMP_TGL_LAHIR' => Yii::t('app', ' BridthDay'),
            'EMP_EMAIL' => Yii::t('app', 'Email'),
			/*LOG HRD*/
			'CREATED_BY'=> Yii::t('app','Created'),
			'UPDATED_BY'=> Yii::t('app','Updated'),
			'UPDATED_TIME'=> Yii::t('app','DateTime'),
			/*Modul HRD*/
            'GRP_NM' => Yii::t('app', 'Modul'),
			
			/*Image Temporary Upload*/
			'upload_file' => Yii::t('app', 'Upload File'),
			
			
			'EMP_JOIN_DATE' => Yii::t('app', 'Join Date'),
			//UMUM
            'corpOne.CORP_NM' => Yii::t('app', 'Company'),
			//UMUM
            'deptOne.DEP_NM' => Yii::t('app', 'Department'),
			//'jobgrade.JOBGRADE_NM' => Yii::t('app', 'Grading'),
			//UMUM
			//'jabOne.JAB_NM' => Yii::t('app', 'Position'),
			//UMUM
            'sttOne.STS_NM' => Yii::t('app', 'Status'), 
			
        ];
    }
	 
	
}


