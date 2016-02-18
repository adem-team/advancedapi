<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel crm\sistem\models\UserposSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Userpos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userpos-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Userpos', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'POSITION_LOGIN',
            'POSITION_NM',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
