<?php

namespace api\modules\efenbi\rasasayang\models;

use Yii;

/**
 * This is the model class for table "locate".
 *
 * @property string $CREATE_BY
 * @property string $CREATE_AT
 * @property string $UPDATE_BY
 * @property string $UPDATE_AT
 * @property integer $STATUS
 * @property integer $ID
 * @property string $PARENT
 * @property string $LOCATE
 * @property string $LOCATE_NAME
 */
class Locate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'locate';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_efenbi');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CREATE_AT', 'UPDATE_AT'], 'safe'],
            [['STATUS'], 'integer'],
            [['CREATE_BY', 'UPDATE_BY'], 'string', 'max' => 50],
            [['PARENT', 'LOCATE_NAME'], 'string', 'max' => 200],
            [['LOCATE'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CREATE_BY' => Yii::t('app', 'Create  By'),
            'CREATE_AT' => Yii::t('app', 'Create  At'),
            'UPDATE_BY' => Yii::t('app', 'Update  By'),
            'UPDATE_AT' => Yii::t('app', 'Update  At'),
            'STATUS' => Yii::t('app', 'Status'),
            'ID' => Yii::t('app', 'ID'),
            'PARENT' => Yii::t('app', 'Parent'),
            'LOCATE' => Yii::t('app', 'Locate'),
            'LOCATE_NAME' => Yii::t('app', 'Locate  Name'),
        ];
    }
}
