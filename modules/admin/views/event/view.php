<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Event $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'События', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="event-view">

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить ?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'label'=>'Дата проведения',
                'value'=>function($model){
                    return date('d.m.Y',strtotime($model->date));
                }
            ],
            'description:ntext',
            [
                'format'=>'raw',
                'label'=>'Организаторы',
                'value'=>function($model){
                    return implode('<br/>',$model->getSelectedOrganizersName());
                }
            ],
        ],
    ]) ?>

</div>
