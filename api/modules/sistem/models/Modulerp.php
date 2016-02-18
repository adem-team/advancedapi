<?php

namespace crm\sistem\models;

use Yii;

/**
 * This is the model class for table "modul".
 *
 * @property string $MODUL_ID
 * @property string $MODUL_NM
 * @property string $MODUL_DCRP
 * @property integer $MODUL_STS
 * @property string $SORT
 */
class Modulerp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'modul';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db1');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MODUL_DCRP'], 'string'],
            [['MODUL_STS', 'SORT'], 'integer'],
            [['MODUL_NM'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MODUL_ID' => 'Modul  ID',
            'MODUL_NM' => 'Modul  Nm',
            'MODUL_DCRP' => 'Modul  Dcrp',
            'MODUL_STS' => 'Modul  Sts',
            'SORT' => 'Sort',
        ];
    }
}
