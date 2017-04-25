<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Buses');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bus-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Bus'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php
    if (!Yii::$app->user->isGuest):
        $roles = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
        $role = array_shift($roles);
        switch ($role->name):
            case 'admin':
                $template = '{view} {update}';
                break;
            case 'admin2':
                $template = '{view} {update} {delete}';
                break;
            default:
                $template = '';
        endswitch;
    else:
        $template = '';
    endif;
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'mark',
            'model',
            'year',
            'average_speed',

            //['class' => 'yii\grid\ActionColumn'],
            [
                'class' => \yii\grid\ActionColumn::className(),
                'template' => $template
            ]
        ],
    ]); ?>
</div>
