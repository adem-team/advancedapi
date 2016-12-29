<?php

namespace api\modules\master\models;

use Yii;

/**
 * This is the model class for table "c0022list".
 *
 * @property string $ID
 * @property string $CASE_NAME
 * @property string $CASE_DSCRIP
 * @property integer $STATUS
 * @property string $CREATED_BY
 * @property string $CREATED_AT
 */
class Roadsaleslist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0022List';
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
            [['CASE_DSCRIP'], 'string'],
            [['STATUS'], 'integer'],
            [['CREATED_AT'], 'safe'],
            [['CASE_NAME'], 'string', 'max' => 255],
            [['CREATED_BY'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'CASE_NAME' => 'Case  Name',
            'CASE_DSCRIP' => 'Case  Dscrip',
            'STATUS' => 'Status',
            'CREATED_BY' => 'Created  By',
            'CREATED_AT' => 'Created  At',
        ];
    }
}
