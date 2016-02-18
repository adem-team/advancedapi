<?php

namespace api\modules\master\models;

use Yii;
use api\modules\master\Perusahaan;

/**
 * This is the model class for table "s1000".
 *
 * @property string $id
 * @property string $kd_supplier
 * @property string $NM_SUPPLIER
 * @property string $alamat
 * @property string $kota
 * @property string $tlp
 * @property string $mobile
 * @property string $fax
 * @property string $email
 * @property string $website
 * @property string $image
 * @property string $NOTE
 * @property string $kd_corp
 * @property string $kd_cab
 * @property string $kd_dep
 * @property integer $status
 * @property string $created_by
 * @property string $created_at
 * @property string $updated_by
 * @property string $updated_at
 * @property string $data_all
 */
class Suplier extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 's1000';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_esm');
    }

	public function getPerusahaan()
    {
        return $this->hasOne(Perusahaan::className(), ['KD_CORP' => 'KD_CORP']);
    }
	
	public function getNmgroup() {
		return $this->perusahaan->NM_CORP;
	}
	
	public static function primaryKey()
    {
      return ['ID'];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['KD_SUPPLIER', 'NM_SUPPLIER','KD_CORP', 'ALAMAT','STATUS'], 'required'],
            [['ALAMAT', 'NOTE', 'DATA_ALL'], 'string'],
            [['STATUS'], 'integer'],
            [['CREATED_AT', 'UPDATED_AT'], 'safe'],
            [['KD_SUPPLIER', 'KD_CORP', 'KD_CAB', 'KD_DEP'], 'string', 'max' => 50],
            [['NM_SUPPLIER', 'WEBSITE', 'IMAGE'], 'string', 'max' => 200],
            [['KOTA', 'TLP', 'MOBILE', 'FAX', 'EMAIL', 'CREATED_BY', 'UPDATED_BY'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'KD_SUPPLIER' => 'Kode Supplier',
            'NM_SUPPLIER' => 'Nama Supplier',
            'ALAMAT' => 'Alamat',
            'KOTA' => 'Kota',
            'TLP' => 'Telephone',
            'MOBILE' => 'Mobile',
            'FAX' => 'Fax',
            'EMAIL' => 'Email',
            'WEBSITE' => 'Website',
            'IMAGE' => 'Gambar',
            'NOTE' => 'Catatan',
            'KD_CORP' => 'Kode Corporasi',
            'KD_CAB' => 'Kode Cab',
            'KD_DEP' => 'Kode Dep',
            'STATUS' => 'Status',
            'CREATED_BY' => 'Created By',
            'CREATED_AT' => 'Created At',
            'UPDATED_BY' => 'Updated By',
            'UPDATED_AT' => 'Updated At',
            'DATA_ALL' => 'Data All',
			'nmgroup' => Yii::t('app', 'Group Perusahaan')
        ];
    }
}
