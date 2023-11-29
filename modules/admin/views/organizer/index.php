<?php

use app\models\Organizer;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\OrganizerSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Организаторы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organizer-index">

    <p>
        <?= Html::a('Добавить организатора', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(['timeout'=>0]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute'=>'id',
                'sortLinkOptions' => [
                    'class' => ($searchModel->order == 'id')?'fa fa-sort-down':(($searchModel->order == '-id')?'fa fa-sort-up':'fa fa-sort'),
                ],
            ],
            [
                'attribute'=>'fio',
                'sortLinkOptions' => [
                    'class' => ($searchModel->order == 'fio')?'fa fa-sort-down':(($searchModel->order == '-fio')?'fa fa-sort-up':'fa fa-sort'),
                ],
            ],
            [
                'attribute'=>'email',
                'sortLinkOptions' => [
                    'class' => ($searchModel->order == 'email')?'fa fa-sort-down':(($searchModel->order == '-email')?'fa fa-sort-up':'fa fa-sort'),
                ],
            ],
            [
                'attribute'=>'phone',
                'sortLinkOptions' => [
                    'class' => ($searchModel->order == 'phone')?'fa fa-sort-down':(($searchModel->order == '-phone')?'fa fa-sort-up':'fa fa-sort'),
                ],
            ],
            [
                'label'=>'Мероприятия',
                'content'=>function($model){
                    return implode('<br/>',$model->getSelectedEventsName());
                }
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Organizer $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
