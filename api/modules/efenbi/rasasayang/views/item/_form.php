<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use kartik\label\LabelInPlace;
use kartik\widgets\Select2;
use yii\helpers\Url;
use kartik\widgets\DepDrop;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use kartik\widgets\DatePicker;
use kartik\widgets\TouchSpin;

	$aryStt= [
			  ['STATUS' => 0, 'STT_NM' => 'Disable'],		  
			  ['STATUS' => 1, 'STT_NM' => 'Enable'],
		];	
	$valStt = ArrayHelper::map($aryStt, 'STATUS', 'STT_NM');
?>

 <?php $form = ActiveForm::begin([
	'id'=>$model->formName(),
	'options'=>['enctype'=>'multipart/form-data'],
	//'enableClientValidation'=> true,
	'enableAjaxValidation'=>true, 															//true = harus beda url action controller dengan post saved  url controller.
	'validationUrl'=>Url::toRoute('/efenbi-rasasayang/item/valid-item'),
	]); ?>
<div style="height:100%;font-family: verdana, arial, sans-serif ;font-size: 8pt">
	<div class="row" >
		<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">	
			<?= $form->field($model, 'ITEM_NM')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'STATUS')->widget(Select2::classname(), [
					'data' =>$valStt,//Yii::$app->gv->gvStatusArray(),
					'options' => ['placeholder' => 'Pilih Status...'],
				]);
			?>
			
		</div>
		<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
			<?=$form->field($model, 'image')->widget(FileInput::classname(), [
				'name'=>'item-input-file',
				'options'=>[
					'width'=>'100px',
					'accept'=>'image/*',
					'multiple'=>false
				],				
				'pluginOptions'=>[
					'allowedFileExtensions'=>['jpg','gif','png'],					
					'showCaption' => false,
					'showRemove' => true,
					'showUpload' => false,
					'showClose' =>false,
					'showDrag' =>false,
					'browseLabel' => 'Select Photo',
					'removeLabel' => '',
					'removeIcon'=> '<i class="glyphicon glyphicon-remove"></i>',
					'removeTitle'=> 'Clear Selected File',
					'defaultPreviewContent' => '<img src="https://www.mautic.org/media/images/default_avatar.png" alt="Your Avatar" style="width:160px">',
					'maxFileSize'=>10 //10KB
					
				],
				'pluginEvents' => [
					'fileclear' => 'function() { log("fileclear"); }',
					'filereset' => 'function() { log("filereset"); }',
				]
				
				
			]); 
			?>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		</div>
	</div>
</div>
<?php ActiveForm::end(); ?>

<?php
$this->registerJs("
 $('#file-input').fileinput({
    // resizeImage: true,
    // maxImageWidth: 160,
    // maxImageHeight: 160,
    // resizePreference: 'width'
	// 'previewSettings':{
		// image: {width: '160px', 'height':'160px'}
	// },

	});
",$this::POS_READY);
?>