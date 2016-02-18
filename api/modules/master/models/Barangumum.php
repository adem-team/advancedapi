<?php

namespace api\modules\master\models;

use Yii;

use api\modules\master\models\Kategori;
use api\modules\master\models\Unitbarang;
use api\modules\master\models\Suplier;
use api\modules\master\models\Perusahaan;
use api\modules\master\models\Tipebarang;

use yii\web\UploadedFile;

/**
 * This is the model class for table "b1000".
 *
 * @property string $id
 * @property string $kd_barang
 * @property string $nm_barang
 * @property string $kd_type
 * @property string $kd_kategori
 * @property string $kd_unit
 * @property string $kd_supplier
 * @property string $kd_distributor
 * @property string $parent
 * @property double $hpp
 * @property double $harga
 * @property string $barcode
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

Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/upload/barangumum/';
Yii::$app->params['uploadUrl'] = Yii::$app->urlManager->baseUrl . '/web/upload/barangumum/';
 
class Barangumum extends \yii\db\ActiveRecord
{

    public function __construct()
    {
        $this->CREATED_AT = date('Y-m-d H:i:s');
        $this->UPDATED_AT = date('Y-m-d H:i:s');
    }

    /**
     * @inheritdoc
     */
	public $image;
	public static function tableName()
    {
        return 'b1000';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_esm');
    }

	public function getType()
    {
        return $this->hasOne(Tipebarang::className(), ['KD_TYPE' => 'KD_TYPE']);
    }
	public function getNmtype()
    {
        return $this->type->NM_TYPE;
    }

	public function getKategori()
    {
        return $this->hasOne(Kategori::className(), ['KD_KATEGORI' => 'KD_KATEGORI']);
    }
	public function getNmktegori()
    {
        return $this->kategori->NM_KATEGORI;
    }

	public function getUnit()
    {
        return $this->hasOne(Unitbarang::className(), ['KD_UNIT' => 'KD_UNIT']);
    }

	public function getSuplier()
    {
        return $this->hasOne(Suplier::className(), ['KD_SUPPLIER' => 'KD_SUPPLIER']);
    }

	public function getPerusahaan()
    {
        return $this->hasOne(Perusahaan::className(), ['ID' => 'CORP_ID']);
    }
	
	public static function primaryKey()
    {
      return ['ID'];
    }
   
	/*
     * @inheritdoc
     */
	 
	//public function attributes() {
        /*
		$attributes = parent::attributes();
        return array_merge($attributes, [
            'Kategori.NM_KATEGORI',
        ]);
		*/
	//	return array_merge(parent::attributes(), ['kategori.NM_KATEGORI']);
   // }
	
	public function extraFields()
	{
		return ['kategori','unit','suplier','perusahaan','type'];
		//return ['unit'];
	}
	
	/*
	public function fields()
	{
		$fields=parent::fields();
		//unset($fields['password']);
		$fields[] = 'kategori.NM_KATEGORI';
		return $fields;
	}
	
	
	/*
	public function fields()
	{
	//	return ['KD_KATEGORI', 'NM_KATEGORI'];
		//return [
		//	'KD_BARANG',
	//		'KD_KATEGORI','NM_KATEGORI',
	//	];	
		$fields = parent::fields();
		
		  //unset($fields['auth_key'], $fields['password_hash'], $fields['password_reset_token']);
		 // $fields = ['KD_BARANG','NM_BARANG'];
		  // $fields[] = 'volume';//,'NM_KATEGORI'];
		  $fields[] = 'Kategori.NM_BARANG'; //,'NM_KATEGORI'];
		return $fields;
	}
	*/
/*
	public function fields()
	{
		return [
			'KD_BARANG',
			'KD_KATEGORI' => function () {
					return $this->NM_KATEGORI ;
			},
		];
	}
	*/
    public function rules()
    {
        return [
            [['KD_BARANG', 'NM_BARANG','STATUS','KD_TYPE','KD_KATEGORI','KD_UNIT', 'KD_SUPPLIER','KD_CORP'], 'required'],
            [['HPP', 'HARGA'], 'number'],
            [['HPP', 'HARGA'], 'required'],
            [['NOTE', 'DATA_ALL'], 'string'],
            [['STATUS'], 'integer'],
            [['CREATED_AT', 'UPDATED_AT'], 'safe'],
            [['KD_BARANG', 'PARENT'], 'string', 'max' => 50],
            [['NM_BARANG', 'IMAGE'], 'string', 'max' => 200],
            [['KD_TYPE', 'KD_KATEGORI', 'KD_UNIT', 'KD_SUPPLIER', 'KD_DISTRIBUTOR', 'KD_CORP', 'KD_CAB', 'KD_DEP'], 'string', 'max' => 50],
            [['BARCODE'], 'string', 'max' => 50],
            [['CREATED_BY', 'UPDATED_BY'], 'string', 'max' => 100],
			[['image'], 'file', 'extensions'=>'jpg, gif, png'],
			//[['kategori.NM_KATEGORI'],'safe'],
		];
    }

    public function getImageFile() 
    {
        return isset($this->IMAGE) ? Yii::$app->params['uploadPath'] . $this->IMAGE : null;
    }
	
    public function getImageUrl() 
    {
        // return a default image placeholder if your source IMAGE is not found
        $IMAGE = isset($this->IMAGE) ? $this->IMAGE : 'default_user.jpg';
        return Yii::$app->params['uploadUrl'] . $IMAGE;
    }
	
	public function uploadImage() {
        // get the uploaded file instance. for multiple file uploads
        // the following data will return an array (you may need to use
        // getInstances method)
        $image = UploadedFile::getInstance($this, 'image');
 
        // if no image was uploaded abort the upload
        if (empty($image)) {
            return false;
        }
 
        // store the source file name
        //$this->filename = $image->name;
        $ext = end((explode(".", $image->name)));
 
        // generate a unique file name
        $this->IMAGE = 'lukison-'.date('ymdHis').".{$ext}"; //$image->name;//Yii::$app->security->generateRandomString().".{$ext}";
 
        // the uploaded image instance
        return $image;
    }
 
	/**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'KD_BARANG' => 'Kode Barang',
            'NM_BARANG' => 'Nama Barang',
            'KD_TYPE' => 'Kode Type',
            'KD_KATEGORI' => 'Kode Kategori',
            'KD_UNIT' => 'Kode Unit',
            'KD_SUPPLIER' => 'Kode Supplier',
            'KD_DISTRIBUTOR' => 'Kode Distributor',
            'PARENT' => 'Parent',
            'HPP' => 'Hpp',
            'HARGA' => 'Harga',
            'BARODE' => 'Barcode',
            'IMAGE' => 'Image',
            'NOTE' => 'Catatan',
            'KD_CORP' => 'Kd Corp',
            'KD_CAB' => 'Kd Cabang',
            'KD_DEP' => 'Kd Departemen',
            'STATUS' => 'Status',
            'CREATED_BY' => 'Created By',
            'CREATED_AT' => 'Created At',
            'UPDATED_BY' => 'Updated By',
            'UPDATED_AT' => 'Updated At',
            'DATA_ALL' => 'Data All',
			'nmtype' => Yii::t('app', 'Type'),
			'nmktegori' => Yii::t('app', 'Kategori'),
			//'kategori.NM_KATEGORI' => Yii::t('app', 'Kategori'),
			
			
        ];
    }
	
}
