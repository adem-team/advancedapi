<?php

namespace api\modules\master\models;

use Yii;

/**
 * This is the model class for table "c0002scdl_img".
 *
 * @property string $ID
 * @property string $ID_DETAIL
 * @property string $IMG_NM_START
 * @property string $IMG_DECODE_START
 * @property integer $STATUS
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 * @property string $IMG_DECODE_END
 * @property string $IMG_NM_END
 * @property string $TIME_END
 * @property string $TIME_START
 */
class Gambar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0002scdl_img';
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
            [['IMG_DECODE_START', 'IMG_DECODE_END'], 'string'],
            [['STATUS'], 'integer'],
            [['CREATE_AT', 'UPDATE_AT', 'TIME_END', 'TIME_START'], 'safe'],
            [['ID_DETAIL'], 'string', 'max' => 20],
            [['IMG_NM_START', 'IMG_NM_END'], 'string', 'max' => 255],
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
            'ID_DETAIL' => 'Id  Detail',
            'IMG_NM_START' => 'Img  Nm  Start',
            'IMG_DECODE_START' => 'Img  Decode  Start',
            'STATUS' => 'Status',
            'CREATE_BY' => 'Create  By',
            'CREATE_AT' => 'Create  At',
            'UPDATE_BY' => 'Update  By',
            'UPDATE_AT' => 'Update  At',
            'IMG_DECODE_END' => 'Img  Decode  End',
            'IMG_NM_END' => 'Img  Nm  End',
            'TIME_END' => 'Time  End',
            'TIME_START' => 'Time  Start',
        ];
    }
}
