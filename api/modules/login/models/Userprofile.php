<?php

namespace api\modules\login\models;

use Yii;

/**
 * This is the model class for table "user_profile".
 *
 * @property string $ID
 * @property string $NM_FIRST
 * @property string $NM_MIDDLE
 * @property string $NM_END
 * @property string $JOIN_DATE
 * @property string $RESIGN_DATE
 * @property integer $STS
 * @property string $EMP_IMG
 * @property string $KD_DISTRIBUTOR
 * @property string $KD_SUBDIST
 * @property string $KD_OUTSRC
 * @property string $KTP
 * @property string $ALAMAT
 * @property string $ZIP
 * @property string $GENDER
 * @property string $TGL_LAHIR
 * @property string $EMAIL
 * @property string $TLP_HOME
 * @property string $HP
 * @property string $CORP_ID
 * @property string $CREATED_BY
 * @property string $CREATED_AT
 * @property string $UPDATED_BY
 * @property string $UPDATED_TIME
 * @property integer $STATUS
 */
class Userprofile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
     public $image;
    public static function tableName()
    {
        return '{{dbm_086.user_profile}}';
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
            [['NM_FIRST', 'NM_MIDDLE', 'NM_END', 'KD_SRC'], 'required'],
            [['ID_USER', 'STS', 'STATUS'], 'integer'],
            [['JOIN_DATE', 'RESIGN_DATE', 'TGL_LAHIR', 'CREATED_AT', 'UPDATED_TIME'], 'safe'],
            [['NM_FIRST', 'NM_MIDDLE', 'NM_END', 'EMP_IMG', 'KTP', 'TLP_HOME', 'HP'], 'string', 'max' => 20],
            [[ 'EMAIL', 'CREATED_BY', 'UPDATED_BY'], 'string', 'max' => 50],
            [['ALAMAT'], 'string', 'max' => 255],
            [['ZIP'], 'string', 'max' => 10],
            [['GENDER', 'CORP_ID'], 'string', 'max' => 6]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID_USER' => 'ID_USER',
            'NM_FIRST' => 'Nm  First',
            'NM_MIDDLE' => 'Nm  Middle',
            'NM_END' => 'Nm  End',
            'JOIN_DATE' => 'Join  Date',
            'RESIGN_DATE' => 'Resign  Date',
            'STS' => 'Sts',
            'EMP_IMG' => 'Emp  Img',
            'KD_DISTRIBUTOR' => 'Kd  Distributor',
            'KTP' => 'Ktp',
            'ALAMAT' => 'Alamat',
            'ZIP' => 'Zip',
            'GENDER' => 'Gender',
            'TGL_LAHIR' => 'Tgl  Lahir',
            'EMAIL' => 'Email',
            'TLP_HOME' => 'Tlp  Home',
            'HP' => 'Hp',
            'CORP_ID' => 'Corp  ID',
            'CREATED_BY' => 'Created  By',
            'CREATED_AT' => 'Created  At',
            'UPDATED_BY' => 'Updated  By',
            'UPDATED_TIME' => 'Updated  Time',
            'STATUS' => 'Status',
        ];
    }
}
