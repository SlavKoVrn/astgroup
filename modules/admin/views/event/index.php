<?php

use app\models\Event;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
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
                            'id',
                            'name',
                            'date',
                            'description:ntext',
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
