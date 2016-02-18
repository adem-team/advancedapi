<?php

namespace api\modules\chart\models;

use Yii;

/**
 * This is the model class for table "Rpt001".
 *
 * @property string $ID
 * @property string $MODUL_NM
 * @property string $VAL_VALUE
 * @property string $DCRP
 * @property string $CREATED_BY
 * @property string $CREATE_AT
 * @property string $UPDATED_BY
 * @property string $UPDATED_TIME
 * @property integer $STATUS
 */
class Rpt001 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rpt001';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_rpt');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['VAL_VALUE', 'DCRP'], 'string'],
            [['CREATE_AT', 'UPDATED_TIME'], 'safe'],
            [['STATUS','MODUL_GRP'], 'integer'],
            [['MODUL_NM'], 'string', 'max' => 100],
            [['CREATED_BY', 'UPDATED_BY'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'MODUL_NM' => 'Modul.Nm',
			'MODUL_GRP' => 'Modul.Grp',
            'VAL_VALUE' => 'Val.Value',
            'DCRP' => 'Dcrp',
            'CREATED_BY' => 'Created/.By',
            'CREATE_AT' => 'Create.At',
            'UPDATED_BY' => 'Updated.By',
            'UPDATED_TIME' => 'Updated.Time',
            'STATUS' => 'Status',
        ];
    }
}
