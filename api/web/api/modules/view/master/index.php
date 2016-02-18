<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel api\modules\master\models\KabSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kabs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kab-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Kab', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'CITY_ID',
            'PROVINCE_ID',
            'PROVINCE',
            'TYPE',
            'CITY_NAME',
            // 'POSTAL_CODE',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
