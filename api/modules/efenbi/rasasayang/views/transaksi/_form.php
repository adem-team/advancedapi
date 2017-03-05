<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\efenbi\rasasayang\models\Transaksi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaksi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'CREATE_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CREATE_AT')->textInput() ?>

    <?= $form->field($model, 'UPDATE_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UPDATE_AT')->textInput() ?>

    <?= $form->field($model, 'STATUS')->textInput() ?>

    <?= $form->field($model, 'TRANS_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TRANS_TYPE')->textInput() ?>

    <?= $form->field($model, 'TRANS_DATE')->textInput() ?>

    <?= $form->field($model, 'USER_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'OUTLET_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'OUTLET_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CONSUMER_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CONSUMER_EMAIL')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CONSUMER_PHONE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ITEM_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ITEM_NM')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ITEM_QTY')->textInput() ?>

    <?= $form->field($model, 'ITEM_HARGA')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ITEM_DISCOUNT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ITEM_DISCOUNT_TIME')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
