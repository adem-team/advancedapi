<?php
use kartik\helpers\Html;
use kartik\widgets\Select2;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use kartik\widgets\Spinner;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\widgets\FileInput;
use yii\helpers\Json;
use yii\web\Response;
use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;
use kartik\tabs\TabsX;
use kartik\date\DatePicker;
use yii\web\View;

$this->sideCorp = 'PT. Efenbi Sukses Makmur';                       	/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'efenbi_rasasayang';                                	/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Marketing Dashboard');              /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;  
$this->registerJs($this->render('modal_itemGroup.js'),View::POS_READY);
echo $this->render('modal_itemGroup'); //echo difinition

	$_indexStore=$this->render('_indexIStore',[
		'storeSearchModel' => $storeSearchModel,
		'storeDataProvider' => $storeDataProvider,
	]);
	$_indexItemsGroup=$this->render('_indexItemGroup',[
		'dataProvider' => $dataProvider,
		'searchModel' => $searchModel,
	]);
?>
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt">
	<div class="col-xs-6 col-sm-4 col-dm-4 col-lg-4" style="font-family: tahoma ;font-size: 9pt;">
		<div class="row" style="padding-right:5px">
			<?=$_indexStore?>
		</div>
	</div>
	<div class="col-xs-6 col-sm-8 col-dm-8 col-lg-8" style="font-family: tahoma ;font-size: 9pt;">
		<div class="row">
			<?=$_indexItemsGroup?>
		</div>
	</div>
</div>
