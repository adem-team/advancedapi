<?php

namespace api\modules\master\models;
use api\modules\master\models\ChildBarang;
use Yii;

/**
 * This is the model class for table "parentbarang".
 *
 * @property integer $id
 * @property string $nama_parent
 * @property string $keterangan
 * @property string $create_at
 * @property integer $create_by
 *
 * @property Childbarang[] $childbarangs
 */
class ParentBarang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parentbarang';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('dblocal');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama_parent', 'keterangan', 'create_at', 'create_by'], 'required'],
            [['keterangan'], 'string'],
            [['create_at'], 'safe'],
            [['create_by'], 'integer'],
            [['nama_parent'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_parent' => 'Nama Parent',
            'keterangan' => 'Keterangan',
            'create_at' => 'Create At',
            'create_by' => 'Create By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildbarangs()
    {
        return $this->hasMany(Childbarang::className(), ['parent' => 'id']);
    }


    public function extraFields()
    {
        return ['childbarangs'];
        //return ['unit'];
    }

    public function relations()
    {
        return array(
            'childbarangs'=>array(self::HAS_MANY, 'ChildBarang', 'parent'),
        );
    }
}
