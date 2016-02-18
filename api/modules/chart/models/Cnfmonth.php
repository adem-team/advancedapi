<?php

namespace api\modules\chart\models;

use Yii;

/*HEADER MONTH*/
class Cnfmonth extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cnfmonth';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_widget');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['label', 'start', 'end', 'bulan', 'tahun'], 'required'],
            [['label'], 'string'],
            [['start', 'end'], 'date'],
            [['bulan', 'tahun'], 'integer']
        ];
    }

     public function fields()
	{
		return [
			'start'=>function($model){
							return Yii::$app->ambilKonvesi->convert($model->start,'date');
					},			
			'end'=>function($model){
							return Yii::$app->ambilKonvesi->convert($model->end,'date');
					},	
			'label',
		];
	}
	
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'label' => 'Label',
            'start' => 'Start',
            'end' => 'End',
            'bulan' => 'Bulan',
            'tahun' => 'Tahun',
        ];
    }
}
