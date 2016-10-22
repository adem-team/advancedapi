<?php

namespace api\modules\lgerp\models;

use Yii;

/**
 * This is the model class for table "bt0003".
 *
 * @property string $ID
 * @property string $KD_BERITA
 * @property string $ID_USER
 * @property string $CHAT
 * @property integer $STATUS
 * @property string $CREATED_BY
 * @property string $CREATED_AT
 * @property string $UPDATED_AT
 * @property string $EMP_IMG
 */
class BeritaAcaraKomentar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bt0003';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('dev_db_widget');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['KD_BERITA', 'ID_USER'], 'required'],
            [['CHAT', 'EMP_IMG'], 'string'],
            [['STATUS'], 'integer'],
            [['CREATED_AT', 'UPDATED_AT'], 'safe'],
            [['KD_BERITA'], 'string', 'max' => 20],
            [['ID_USER'], 'string', 'max' => 15],
            [['CREATED_BY'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'KD_BERITA' => 'Kd  Berita',
            'ID_USER' => 'Id  User',
            'CHAT' => 'Chat',
            'STATUS' => 'Status',
            'CREATED_BY' => 'Created  By',
            'CREATED_AT' => 'Created  At',
            'UPDATED_AT' => 'Updated  At',
            'EMP_IMG' => 'Emp  Img',
        ];
    }
}
