<?php
namespace api\modules\chart\models;
use Yii;
/*ACTUAL TASK*/
class Pilotactual extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'sc0001';
    }
  
    public static function getDb()
    {
        return Yii::$app->get('db_widget');
    }

    public function rules()
    {
        return [
            [['PARENT','PILOT_ID', 'STATUS','SORT','BOBOT'], 'integer'],
            [['PLAN_DATE1','PLAN_DATE2','ACTUAL_DATE1', 'ACTUAL_DATE2','UPDATED_TIME'], 'safe'],
            [['PILOT_NM','label'], 'string', 'max' => 255],
			[['DSCRP'], 'string'],
            [['CORP_ID', 'DEP_ID'], 'string', 'max' => 6],
			[['DESTINATION_TO','CREATED_BY','UPDATED_BY'], 'string', 'max' => 50]			
        ];
    }
	public function fields()
	{
		return [
			'label'=>function($model){
							return 'Actual';
					},			
			'processid'=>function($model){
							return "" .$model->ID .""; //Harus String atau tanda ""
					},
			'start'=>function($model){
						if (($model->STATUS)==1){ /*CLOSING*/
							if ($model->PLAN_DATE1<>0 AND $model->PLAN_DATE2<>0 AND $model->ACTUAL_DATE1<>0 AND $model->ACTUAL_DATE2<>0){
								return Yii::$app->ambilKonvesi->convert($model->ACTUAL_DATE1,'date');
							}elseif ($model->PLAN_DATE1<>0 AND $model->PLAN_DATE2<>0 AND $model->ACTUAL_DATE1<>0 AND $model->ACTUAL_DATE2==0){
								return Yii::$app->ambilKonvesi->convert($model->ACTUAL_DATE1,'date');
							}else{
								return '';
							}
						}elseif(($model->STATUS)==0){ /*RUN*/
							if ($model->PLAN_DATE1<>0 AND $model->PLAN_DATE2<>0 AND $model->ACTUAL_DATE1<>0 AND $model->ACTUAL_DATE2<>0){
								return Yii::$app->ambilKonvesi->convert($model->ACTUAL_DATE1,'date');
							}elseif ($model->PLAN_DATE1<>0 AND $model->PLAN_DATE2<>0 AND $model->ACTUAL_DATE1<>0 AND $model->ACTUAL_DATE2==0){
								return Yii::$app->ambilKonvesi->convert($model->ACTUAL_DATE1,'date');
							}else{
								return '';
							}							
						}
							
					},			
			'end'=>function($model){
						if (($model->STATUS)==1){ /*CLOSING*/
							if ($model->PLAN_DATE1<>0 AND $model->PLAN_DATE2<>0 AND $model->ACTUAL_DATE1<>0 AND $model->ACTUAL_DATE2<>0){
								return Yii::$app->ambilKonvesi->convert($model->ACTUAL_DATE2,'date');
							}elseif($model->PLAN_DATE1<>0 AND $model->PLAN_DATE2<>0 AND $model->ACTUAL_DATE1<>0 AND $model->ACTUAL_DATE2==0){
								return Yii::$app->ambilKonvesi->convert($model->PLAN_DATE2,'date'); 
							}else{
								return '';
							}		
						}elseif (($model->STATUS)==0){ /* ACTUAL RUNNING PROGRASS*/
							if ($model->PLAN_DATE1<>0 AND $model->PLAN_DATE2<>0 AND $model->ACTUAL_DATE1<>0 AND $model->ACTUAL_DATE2==0){
								if ((Yii::$app->ambilKonvesi->convert(date('d-m-Y'),'date'))<(Yii::$app->ambilKonvesi->convert($model->PLAN_DATE2,'date'))){
									return Yii::$app->ambilKonvesi->convert(date('d-m-Y'),'date');		/*PENAMBAHAN HARI*/	
								}else{
									return Yii::$app->ambilKonvesi->convert($model->PLAN_DATE2,'date');
								}								
							}elseif($model->PLAN_DATE1<>0 AND $model->PLAN_DATE2<>0 AND $model->ACTUAL_DATE1<>0 AND $model->ACTUAL_DATE2<>0){
								if ((Yii::$app->ambilKonvesi->convert(date('d-m-Y'),'date'))<(Yii::$app->ambilKonvesi->convert($model->PLAN_DATE2,'date'))){
									return Yii::$app->ambilKonvesi->convert(date('d-m-Y'),'date');		/*PENAMBAHAN HARI*/	
								}else{
									return Yii::$app->ambilKonvesi->convert($model->PLAN_DATE2,'date');
								}									
							}else{
								return ''; 
							}							
						}
					},
			'id'=>function($model){
							return "" .$model->ID .""; //Harus String atau tanda ""
					},
			'color'=>function($model){
							return '#4DFF4D';
					},
            'height'=>function($model){
							return '12';
					}, 
            'toppadding'=>function($model){
							return '24';
					}
		];
	}
	public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'PARENT' => 'Parent',
			'SORT'=>'Sort',
			'PILOT_ID' => 'Pilot.ID',
            'PILOT_NM' => 'Schedule.Nm',
			'DSCRP' => 'Description',
            'PLAN_DATE1' => 'Start.Planned',
            'PLAN_DATE2' => 'End.Planned',            
            'ACTUAL_DATE1' => 'Actual.Opening',
            'ACTUAL_DATE2' => 'Actual.Closing',
			'DESTINATION_TO'=>'Send-To',
			'BOBOT'=>'Lavel',
            'CORP_ID' => 'Corp.ID',
            'DEP_ID' => 'Dept.ID',
            'CREATED_BY'=> 'Created',
			'UPDATED_BY'=> 'Updated',
			'UPDATED_TIME'=> 'DateTime',
			'STATUS' => 'Status',
        ];
    }
}
