<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\efenbi\rasasayang\models\TransaksiSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaksi-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'CREATE_BY') ?>

    <?= $form->field($model, 'CREATE_AT') ?>

    <?= $form->field($model, 'UPDATE_BY') ?>

    <?= $form->field($model, 'UPDATE_AT') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

    <?php // echo $form->field($model, 'TRANS_ID') ?>

    <?php // echo $form->field($model, 'TRANS_TYPE') ?>

    <?php // echo $form->field($model, 'TRANS_DATE') ?>

    <?php // echo $form->field($model, 'USER_ID') ?>

    <?php // echo $form->field($model, 'OUTLET_ID') ?>

    <?php // echo $form->field($model, 'OUTLET_NM') ?>

    <?php // echo $form->field($model, 'CONSUMER_NM') ?>

    <?php // echo $form->field($model, 'CONSUMER_EMAIL') ?>

    <?php // echo $form->field($model, 'CONSUMER_PHONE') ?>

    <?php // echo $form->field($model, 'ITEM_ID') ?>

    <?php // echo $form->field($model, 'ITEM_NM') ?>

    <?php // echo $form->field($model, 'ITEM_QTY') ?>

    <?php // echo $form->field($model, 'ITEM_HARGA') ?>

    <?php // echo $form->field($model, 'ITEM_DISCOUNT') ?>

    <?php // echo $form->field($model, 'ITEM_DISCOUNT_TIME') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
