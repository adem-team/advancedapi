<?php
use kartik\helpers\Html;
use kartik\detail\DetailView;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;
use kartik\widgets\ActiveField;
use kartik\widgets\ActiveForm;

	$aryStt= [
	  ['STATUS' => 0, 'STT_NM' => 'Disable'],		  
	  ['STATUS' => 1, 'STT_NM' => 'Enable']
	];	
	$valStt = ArrayHelper::map($aryStt, 'STATUS', 'STT_NM');
	
	$attributeItem=[
		[
			'attribute' =>'ITEM_ID',
			'labelColOptions' => ['style' => 'text-align:right;width: 30%'],
			'displayOnly'=>true,	
			'format'=>'raw', 
            'value'=>'<kbd>'.$model->ITEM_ID.'</kbd>',
		],
		[
			'attribute' =>'ITEM_NM',
			'type'=>DetailView::INPUT_TEXTAREA,
			'labelColOptions' => ['style' => 'text-align:right;width: 30%'],
			//'displayOnly'=>true,	
			'format'=>'raw', 
            //'value'=>'<kbd>'.$model->ITEM_NM.'</kbd>',
		],
		[
			'attribute' =>'CREATE_BY',
			'format'=>'raw',
			'type'=>DetailView::INPUT_DATE,
			'widgetOptions' => [
				'pluginOptions'=>Yii::$app->gv->gvPliginDate()
			],
			'labelColOptions' => ['style' => 'text-align:right;width: 30%']
		],
		[
			'attribute' =>'CREATE_BY',
			'format'=>'raw',
			'type'=>DetailView::INPUT_DATE,
			'widgetOptions' => [
				'pluginOptions'=>Yii::$app->gv->gvPliginDate()
			],
			'labelColOptions' => ['style' => 'text-align:right;width: 30%']
		],
		[
			'attribute' =>'STATUS',			
			'format'=>'raw',
			'value'=>$model->STATUS==0?'Disable':($model->STATUS==1?'Enable':'Unknown'),
			'type'=>DetailView::INPUT_SELECT2,
			'widgetOptions'=>[
				'data'=>$valStt,//Yii::$app->gv->gvStatusArray(),
				'options'=>['id'=>'status-review-id','placeholder'=>'Select ...'],
				'pluginOptions'=>['allowClear'=>true],
			],	
			'labelColOptions' => ['style' => 'text-align:right;width: 30%'],
		]
	];
	
	$dvItems=DetailView::widget([
		'id'=>'dv-items',
		'model' => $model,
		'attributes'=>$attributeItem,
		'condensed'=>true,
		'hover'=>true,
		'panel'=>[
			'heading'=>'
				<span class="fa-stack fa-1">
					  <i class="fa fa-circle fa-stack-2x" style="color:#635e5e"></i>
					  <i class="fa fa-list-ul fa-stack-1x" style="color:#ffffff"></i>
				</span> <b>Discription Detail</b>
			',
			'type'=>DetailView::TYPE_INFO,
		],
		'mode'=>DetailView::MODE_VIEW,
		'buttons1'=>'{update}',
		'buttons2'=>'{view}{save}',		
		/* 'saveOptions'=>[ 
			'id' =>'editBtn1',
			'value'=>'/marketing/sales-promo/review?id='.$model->ID,
			'params' => ['custom_param' => true],
		],	 */	
	]);
	
	$attributeImage = [		
		[
			'attribute' =>'image',
			'label'=>false,
			'value'=> $model->IMG64!=''?Html::img('data:image/jpg;charset=utf-8;base64,'.$model->IMG64):Html::img('data:image/jpg;charset=utf-8;base64,'.$model->noimage),
			'format'=>['raw',['width'=>'100','height'=>'120']],
			'type' => DetailView::INPUT_FILEINPUT,
			'widgetOptions'=>[
				'pluginOptions' => [
					'showPreview' => true,
					'showCaption' => false,
					'showRemove' => false,
					'showUpload' => false
				],

			],
			//'inputWidth'=>'100%',
			//'inputContainer' => ['class'=>'col-lg-5'],
		],
	];
	
	$dvItemImage=DetailView::widget([
			'id'=>'dv-items-image',
			'model' => $model,
			'attributes'=>$attributeImage,
			'condensed'=>true,
			'hover'=>true,
			'panel'=>[
				'heading'=>'
					<span class="fa-stack fa-1">
						  <i class="fa fa-circle fa-stack-2x" style="color:#635e5e"></i>
						  <i class="fa fa-list-ul fa-stack-1x" style="color:#ffffff"></i>
					</span> <b>Discription Detail</b>
				',
				'type'=>DetailView::TYPE_INFO,
			],
			'mode'=>DetailView::MODE_VIEW,
			'buttons1'=>'{update}',
			'buttons2'=>'{view}{save}',		
			'saveOptions'=>[ 
				'id' =>'editBtn2',
				'value'=>'/efenbi-rasasayang/item/view?id='.$model->ITEM_ID,
				'params' => ['custom_param' => true],
			],	
		]);
	
	
?>
<div style="height:100%;font-family: verdana, arial, sans-serif ;font-size: 8pt">
	<div class="row" >
		
		<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
		<div class="row" >
			<?php
			$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL,
				'id'=>'viewedit-image',
				'enableClientValidation' => true,
				'options'=>['enctype'=>'multipart/form-data']
			]);
				echo $dvItemImage;
			ActiveForm::end();
			?>
		</div>
		</div>
		<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
			<?=$dvItems ?>
		</div>
	</div>
</div>