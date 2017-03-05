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
	
	$bColorStore='rgba(52, 235, 138, 1)';
	$gvAttributeStore=[
		[
			'class'=>'kartik\grid\SerialColumn',
			'contentOptions'=>['class'=>'kartik-sheet-style'],
			'width'=>'10px',
			'header'=>'No.',
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','30px',$bColorStore),
			'contentOptions'=>Yii::$app->gv->gvContainBody('center','30px',''),
		],
		//CABANG LOCATE 
		[
			'attribute'=>'LocateNm',
			//'label'=>'Cutomer',
			'filterType'=>true,
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','150px'),
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColorStore)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','150px',$bColorStore),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','150px',''),
			
		],		
		//SABANG LOCATE SUB
		[
			'attribute'=>'LocatesubNm',
			//'label'=>'Cutomer',
			'filterType'=>true,
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','100px'),
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColorStore)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','100px',$bColorStore),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','100px',''),
			
		],		
		//STORE NAME
		[
			'attribute'=>'OUTLET_NM',
			//'label'=>'Cutomer',
			'filterType'=>true,
			'filterOptions'=>Yii::$app->gv->gvFilterContainHeader('0','200px'),
			'hAlign'=>'right',
			'vAlign'=>'middle',
			'mergeHeader'=>false,
			'noWrap'=>false,
			//gvContainHeader($align,$width,$bColorStore)
			'headerOptions'=>Yii::$app->gv->gvContainHeader('center','200px',$bColorStore),
			'contentOptions'=>Yii::$app->gv->gvContainBody('left','200px',''),
			
		],
		
	];

	$gvItemGroupStore=GridView::widget([
		'id'=>'gv-item-group-store',
		'dataProvider' => $storeDataProvider,
		'filterModel' => $storeSearchModel,
		'rowOptions'   => function ($model, $key, $index, $grid) {
			return ['id'=>	[$model->ID,$model->LOCATE_SUB],'onclick' => '$.pjax.reload({
				url: "'.Url::to([
							'/efenbi-rasasayang/item-group/index'
						]).'?locate='.$model->LOCATE.'&locatesub='.$model->LOCATE_SUB.'",
				container: "#gv-item-group",
				timeout: 1000,
			});'];
			//  return ['data-id' => $model->USER_ID];
		},
		'columns'=>$gvAttributeStore,				
		'pjax'=>true,
		'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'gv-item-group-store',
		    ],						  
		],
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>true,
		'autoXlFormat'=>true,
		'export' => false,
		'panel'=>[''],
		'toolbar' => [
			''
		],
		'panel' => [
			//'heading'=>false,
			'heading'=>'OUTLET',  
			'type'=>'info',
			'showFooter'=>false,
		],
		'floatOverflowContainer'=>true,
		'floatHeader'=>true,
	]); 
	
?>
<?=$gvItemGroupStore?>
