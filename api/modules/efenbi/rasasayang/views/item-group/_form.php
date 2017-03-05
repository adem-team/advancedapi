<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\efenbi\rasasayang\models\ItemGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'CREATE_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CREATE_AT')->textInput() ?>

    <?= $form->field($model, 'UPDATE_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UPDATE_AT')->textInput() ?>

    <?= $form->field($model, 'STATUS')->textInput() ?>

    <?= $form->field($model, 'LOCATE')->textInput() ?>

    <?= $form->field($model, 'LOCATE_DCRP')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LOCATE_SUB')->textInput() ?>

    <?= $form->field($model, 'LOCATE_SUB_DCRP')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'OUTLET_ID')->textInput() ?>

    <?= $form->field($model, 'OUTLET_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'OUTLET_BARCODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ITEM_ID')->textInput() ?>

    <?= $form->field($model, 'ITEM_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ITEM_BARCODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PERSEN_MARGIN')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
