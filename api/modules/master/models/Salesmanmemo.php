<?php

namespace api\modules\master\models;

use Yii;

/**
 * This is the model class for table "c0013".
 *
 * @property integer $ID
 * @property string $CREATE_AT
 * @property integer $CREATE_BY
 * @property string $UPDATE_AT
 * @property integer $UPDATE_BY
 * @property integer $STATUS
 * @property string $ISI_MESSAGES
 * @property integer $ID_USER
 * @property string $NM_USER
 * @property string $STATUS_MESSAGES
 */
class Salesmanmemo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0013';
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
            [['ID', 'CREATE_BY', 'UPDATE_BY', 'STATUS', 'ID_USER'], 'integer'],
            [['CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['ISI_MESSAGES'], 'string'],
            [['NM_USER', 'STATUS_MESSAGES'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'CREATE_AT' => 'Create  At',
            'CREATE_BY' => 'Create  By',
            'UPDATE_AT' => 'Update  At',
            'UPDATE_BY' => 'Update  By',
            'STATUS' => 'Status',
            'ISI_MESSAGES' => 'Isi  Messages',
            'ID_USER' => 'Id  User',
            'NM_USER' => 'Nm  User',
            'STATUS_MESSAGES' => 'Status  Messages',
        ];
    }
}
