<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model api\modules\master\models\Kab */

$this->title = 'Update Kab: ' . ' ' . $model->CITY_ID;
$this->params['breadcrumbs'][] = ['label' => 'Kabs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CITY_ID, 'url' => ['view', 'id' => $model->CITY_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kab-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
