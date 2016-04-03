<?php

namespace api\modules\master\models;

use Yii;

/**
 * This is the model class for table "c0002scdl_img".
 *
 * @property string $ID
 * @property string $ID_DETAIL
 * @property string $IMG_NM
 * @property string $IMG_DECODE
 * @property integer $STATUS
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 */
class Gambarkunjungan extends \yii\db\ActiveRecord
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

    public function __construct()
    {
        $this->CREATE_AT = date('Y-m-d H:i:s');
        $this->UPDATE_AT = date('Y-m-d H:i:s');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IMG_DECODE','STATUS','CREATE_AT', 'ID_DETAIL', 'IMG_NM','CREATE_BY'],'required'],
            [['IMG_DECODE'], 'string'],
            [['STATUS'], 'integer'],
            [['CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['ID_DETAIL'], 'string', 'max' => 20],
            [['IMG_NM'], 'string', 'max' => 255],
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
            'IMG_NM' => 'Img  Nm',
            'IMG_DECODE' => 'Img  Decode',
            'STATUS' => 'Status',
            'CREATE_BY' => 'Create  By',
            'CREATE_AT' => 'Create  At',
            'UPDATE_BY' => 'Update  By',
            'UPDATE_AT' => 'Update  At',
        ];
    }
}
