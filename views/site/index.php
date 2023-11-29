<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';

use app\models\Event;
use kartik\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Url;
use yii\widgets\Pjax; ?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Отображение мероприятий и их организаторов</h1>
    </div>

    <div class="content">
        <div class="row">
            <div class="col col-sm-12">
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
                    ],
                ]); ?>

                <?php Pjax::end(); ?>

            </div>
        </div>
    </div>

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="https://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4 mb-3">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-outline-secondary" href="https://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4 mb-3">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-outline-secondary" href="https://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-outline-secondary" href="https://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
