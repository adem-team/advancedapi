<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model api\modules\master\models\Kab */

$this->title = $model->CITY_ID;
$this->params['breadcrumbs'][] = ['label' => 'Kabs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kab-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->CITY_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->CITY_ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'CITY_ID',
            'PROVINCE_ID',
            'PROVINCE',
            'TYPE',
            'CITY_NAME',
            'POSTAL_CODE',
        ],
    ]) ?>

</div>
