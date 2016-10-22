<?php

namespace api\modules\lgerp\models;

use Yii;

/**
 * This is the model class for table "bt0001".
 *
 * @property string $ID
 * @property string $KD_BERITA
 * @property string $JUDUL
 * @property string $ISI
 * @property string $KD_CORP
 * @property string $KD_CAB
 * @property string $KD_DEP
 * @property string $DATA_PICT
 * @property string $DATA_FILE
 * @property integer $STATUS
 * @property string $CREATED_ATCREATED_BY
 * @property string $CREATED_BY
 * @property string $UPDATE_AT
 * @property string $DATA_ALL
 * @property string $KD_REF
 * @property string $USER_CC
 */
class BeritaAcara extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bt0001';
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
            [['KD_BERITA'], 'required'],
            [['ISI', 'DATA_PICT', 'DATA_FILE', 'DATA_ALL', 'USER_CC'], 'string'],
            [['STATUS'], 'integer'],
            [['CREATED_ATCREATED_BY', 'UPDATE_AT'], 'safe'],
            [['KD_BERITA', 'KD_CORP', 'KD_CAB', 'KD_DEP'], 'string', 'max' => 20],
            [['JUDUL'], 'string', 'max' => 200],
            [['CREATED_BY'], 'string', 'max' => 100],
            [['KD_REF'], 'string', 'max' => 50]
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
            'JUDUL' => 'Judul',
            'ISI' => 'Isi',
            'KD_CORP' => 'Kd  Corp',
            'KD_CAB' => 'Kd  Cab',
            'KD_DEP' => 'Kd  Dep',
            'DATA_PICT' => 'Data  Pict',
            'DATA_FILE' => 'Data  File',
            'STATUS' => 'Status',
            'CREATED_ATCREATED_BY' => 'Created  Atcreated  By',
            'CREATED_BY' => 'Created  By',
            'UPDATE_AT' => 'Update  At',
            'DATA_ALL' => 'Data  All',
            'KD_REF' => 'Kd  Ref',
            'USER_CC' => 'User  Cc',
        ];
    }
}
