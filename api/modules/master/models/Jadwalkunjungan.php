<?php

namespace api\modules\master\models;

use Yii;

/**
 * This is the model class for table "c0002scdl_header".
 *
 * @property string $ID
 * @property string $TGL1
 * @property string $TGL2
 * @property string $SCDL_GROUP
 * @property string $USER_ID
 * @property string $NOTE
 * @property integer $STATUS
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 */
class Jadwalkunjungan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0002scdl_header';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db3');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TGL1', 'TGL2', 'CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['SCDL_GROUP', 'STATUS'], 'integer'],
            [['NOTE'], 'string'],
            [['USER_ID'], 'string', 'max' => 50],
            [['CREATE_BY', 'UPDATE_BY'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'TGL1' => 'Tgl1',
            'TGL2' => 'Tgl2',
            'SCDL_GROUP' => 'Scdl  Group',
            'USER_ID' => 'User  ID',
            'NOTE' => 'Note',
            'STATUS' => 'Status',
            'CREATE_BY' => 'Create  By',
            'CREATE_AT' => 'Create  At',
            'UPDATE_BY' => 'Update  By',
            'UPDATE_AT' => 'Update  At',
        ];
    }
}
