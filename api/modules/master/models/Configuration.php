<?php

namespace api\modules\master\models;

use Yii;

/**
 * This is the model class for table "C0010".
 *
 * @property integer $id
 * @property string $checkin
 * @property integer $value
 * @property string $note
 */
class Configuration extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'c0010';
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
            [['valueradius'], 'integer'],
            [['checkin', 'note'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'checkin' => 'Checkin',
            'valueradius' => 'Valueradius',
            'note' => 'Note',
        ];
    }
}
