<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel crm\sistem\models\UserprofileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Userprofiles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userprofile-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Userprofile', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'ID',
            'NM_FIRST',
            'NM_MIDDLE',
            'NM_END',
            'JOIN_DATE',
            // 'RESIGN_DATE',
            // 'STS',
            // 'EMP_IMG',
            // 'KD_DISTRIBUTOR',
            // 'KD_SUBDIST',
            // 'KD_OUTSRC',
            // 'KTP',
            // 'ALAMAT',
            // 'ZIP',
            // 'GENDER',
            // 'TGL_LAHIR',
            // 'EMAIL:email',
            // 'TLP_HOME',
            // 'HP',
            // 'CORP_ID',
            // 'CREATED_BY',
            // 'CREATED_AT',
            // 'UPDATED_BY',
            // 'UPDATED_TIME',
            // 'STATUS',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
