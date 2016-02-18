<?php

namespace api\modules\master\models;

use Yii;

/**
 * This is the model class for table "c1000".
 *
 * @property integer $id
 * @property string $kd_corp
 * @property string $NM_CORP
 */
class Perusahaan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lg1001';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_esm');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'KD_CORP', 'NM_CORP'], 'required'],
            [['ID'], 'integer'],
            [['KD_CORP'], 'string', 'max' => 50],
            [['NM_CORP'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'KD_CORP' => 'Kd Corp',
            'NM_CORP' => 'Nm Corp',
        ];
    }
}
