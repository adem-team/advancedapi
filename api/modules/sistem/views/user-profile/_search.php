<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model crm\sistem\models\UserprofileSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="userprofile-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'NM_FIRST') ?>

    <?= $form->field($model, 'NM_MIDDLE') ?>

    <?= $form->field($model, 'NM_END') ?>

    <?= $form->field($model, 'JOIN_DATE') ?>

    <?php // echo $form->field($model, 'RESIGN_DATE') ?>

    <?php // echo $form->field($model, 'STS') ?>

    <?php // echo $form->field($model, 'EMP_IMG') ?>

    <?php // echo $form->field($model, 'KD_DISTRIBUTOR') ?>

    <?php // echo $form->field($model, 'KD_SUBDIST') ?>

    <?php // echo $form->field($model, 'KD_OUTSRC') ?>

    <?php // echo $form->field($model, 'KTP') ?>

    <?php // echo $form->field($model, 'ALAMAT') ?>

    <?php // echo $form->field($model, 'ZIP') ?>

    <?php // echo $form->field($model, 'GENDER') ?>

    <?php // echo $form->field($model, 'TGL_LAHIR') ?>

    <?php // echo $form->field($model, 'EMAIL') ?>

    <?php // echo $form->field($model, 'TLP_HOME') ?>

    <?php // echo $form->field($model, 'HP') ?>

    <?php // echo $form->field($model, 'CORP_ID') ?>

    <?php // echo $form->field($model, 'CREATED_BY') ?>

    <?php // echo $form->field($model, 'CREATED_AT') ?>

    <?php // echo $form->field($model, 'UPDATED_BY') ?>

    <?php // echo $form->field($model, 'UPDATED_TIME') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
