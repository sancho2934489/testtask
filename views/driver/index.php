<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\imagine\Image;
use yii\web\JqueryAsset;
use yii\web\View;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DriverSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Drivers');
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('js/active.js',
    [
        'depends' => [JqueryAsset::className()],
        'position' => View::POS_HEAD
    ]);

$this->registerJsFile('//api-maps.yandex.ru/2.1/?load=package.standard&lang=ru-RU',
    [
        'depends' => [\yii\web\JqueryAsset::className()],
        'position' => yii\web\View::POS_HEAD
    ]);

$this->registerJsFile('js/maps1.js',
    [
        'depends' => [\yii\web\JqueryAsset::className()],
        'position' => yii\web\View::POS_HEAD
    ]);
?>
<div id="map" style="display: none"></div>
<div class="driver-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Driver'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div>
        <?=Html::label('Первый город','address1')?>
        <?=Html::textInput('city_from','',['id' => 'address1'])?>
        <?=Html::label('Второй город','address2')?>
        <?=Html::textInput('city_to','',['id' => 'address2'])?>
        <?=Html::label('Расстояние(км)','distance')?>
        <?=Html::textInput('distance','',['id' => 'distance'])?>
        <?=Html::button('Расчитать',['onclick' => 'createRoute()','class' => 'btn btn-success'])?>
    </div>
<?php Pjax::begin();
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

            [
                'attribute'=>'photo',
                'enableSorting' => false,
                'content'=>function($data){
                    Image::thumbnail(Yii::getAlias('@upload').'/' . $data->photo,100,100)->save(Yii::getAlias('@thumb').'/' . $data->photo, ['quality' => 50]);
                    $html = Html::img(Yii::getAlias('@img_thumb').'/'.$data->photo);
                    return $html;
                }
            ],
            'fio',
            [
                'attribute' => 'birthday',
                'content' => function($data) {
                    return date("Y-m-d") - $data->birthday;
                }
            ],
            [
                'attribute' => 'active',
                'content' => function($data) {
                    return Html::checkbox('active',$data->active,[
                        'onchange' => 'upActive($(this))',
                        'data-id' => $data->id,
                    ]);
                }
            ],
            [
                'label' => 'Время',
                'content' => function($data) {
                    return Html::label('','',['id' => 'time_'.$data->id]);
                }
            ],

            //['class' => 'yii\grid\ActionColumn'],
            [
                'class' => \yii\grid\ActionColumn::className(),
                'template' => $template
            ]
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
