<?php

use app\models\Event;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\EventSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'События';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-index">
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-body with-border">
                    <?= Html::a('Добавить событие', ['create'], ['class' => 'btn btn-success']) ?>
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
                                'attribute'=>'name',
                                'sortLinkOptions' => [
                                    'class' => ($searchModel->order == 'name')?'fa fa-sort-down':(($searchModel->order == '-name')?'fa fa-sort-up':'fa fa-sort'),
                                ],
                            ],
                            [
                                'filterType' => GridView::FILTER_DATE_RANGE,
                                'filterWidgetOptions' =>([
                                    'model'=>$searchModel,
                                    'attribute'=>'date',
                                    'presetDropdown'=>TRUE,
                                    'convertFormat'=>true,
                                    'pluginOptions'=>[
                                        'format'=>'d.m.Y',
                                        'opens'=>'left'
                                    ]
                                ]),
                                'sortLinkOptions' => [
                                    'class' => ($searchModel->order == 'date')?'fa fa-sort-down':(($searchModel->order == '-date')?'fa fa-sort-up':'fa fa-sort'),
                                ],
                                'attribute'=>'date',
                                'content'=>function($model){
                                    return date('d.m.Y',strtotime($model->date));
                                }
                            ],
                            [
                                'label'=>'Организаторы',
                                'content'=>function($model){
                                    return implode('<br/>',$model->getSelectedOrganizersName());
                                }
                            ],
                            [
                                'class' => ActionColumn::className(),
                                'urlCreator' => function ($action, Event $model, $key, $index, $column) {
                                    return Url::toRoute([$action, 'id' => $model->id]);
                                }
                            ],
                        ],
                    ]); ?>

                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
