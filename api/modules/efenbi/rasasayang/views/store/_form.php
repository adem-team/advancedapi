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
use lukisongroup\efenbi\rasasayang\models\Locate;
	$aryStt= [
			  ['STATUS' => 0, 'STT_NM' => 'Disable'],		  
			  ['STATUS' => 1, 'STT_NM' => 'Enable'],
		];	
	$valStt = ArrayHelper::map($aryStt, 'STATUS', 'STT_NM');

	$aryLocate = ArrayHelper::map(Locate::find()->where(['PARENT' => 0])->all(), 'ID', 'LOCATE_NAME');
		
	$form = ActiveForm::begin([
		'id'=>$model->formName(),
		//'options'=>['enctype'=>'multipart/form-data'],
		//'enableClientValidation'=> true,
		//'enableAjaxValidation'=>true, 
		//'validationUrl'=>Url::toRoute('/efenbi/item/valid-item'),
	]); ?>
		<div style="height:100%;font-family: verdana, arial, sans-serif ;font-size: 8pt">
			<div class="row" >
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">	
					
					<?= $form->field($model, 'LOCATE')->widget(Select2::classname(), [
							'data' =>$aryLocate ,
							'options' => ['placeholder' => 'Pilih Customers Parent...'],
							// 'pluginOptions' => [
								// 'allowClear' => true
							// ],
						])->label('Locate');
					?>
					<?php
						echo $form->field($model, 'LOCATE_SUB')->widget(DepDrop::classname(), [
							'type'=>DepDrop::TYPE_SELECT2,
							'options' => [
								'id'=>'store-locate_sub',
								//'placeholder' => 'Select Locate-Sub '
							],
							// 'select2Options'=>[
								// 'pluginOptions'=>[
									// 'allowClear'=>true
								// ]
							// ],
							'pluginOptions' => [
								'depends'=>['store-locate'],
								'url'=>Url::to(['/efenbi-rasasayang/store/locate-sub']),
								//'initialize'=>true,
								'loadingText' => 'Loading data ...',
							],
						]);
					?>					
					<?= $form->field($model, 'OUTLET_NM')->textInput(['maxlength' => true]) ?>
					
					<?= $form->field($model, 'PIC')->textInput(['maxlength' => true]) ?>

					<?= $form->field($model, 'TLP')->textInput(['maxlength' => true]) ?>
		
					<?= $form->field($model, 'ALAMAT')->textarea(['rows' => 6]) ?>
					 
					<?= $form->field($model, 'STATUS')->widget(Select2::classname(), [
							'data' =>$valStt,//Yii::$app->gv->gvStatusArray(),
							'options' => ['placeholder' => 'Pilih Status...'],
						]);
					?>			
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
				</div>
			</div>
		</div>
	<?php ActiveForm::end(); ?>

