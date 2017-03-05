<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\efenbi\models\ItemFormulaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-formula-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID_DTL_FORMULA') ?>

    <?= $form->field($model, 'CREATE_BY') ?>

    <?= $form->field($model, 'CREATE_AT') ?>

    <?= $form->field($model, 'UPDATE_BY') ?>

    <?= $form->field($model, 'UPDATE_AT') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

    <?php // echo $form->field($model, 'TYPE') ?>

    <?php // echo $form->field($model, 'TYPE_NM') ?>

    <?php // echo $form->field($model, 'ID_STORE') ?>

    <?php // echo $form->field($model, 'ID_ITEM') ?>

    <?php // echo $form->field($model, 'DISCOUNT_PESEN') ?>

    <?php // echo $form->field($model, 'DISCOUNT_WAKTU') ?>

    <?php // echo $form->field($model, 'DISCOUNT_HARI') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
