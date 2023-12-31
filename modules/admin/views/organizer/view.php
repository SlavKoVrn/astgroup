<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Organizer $model */

$this->title = $model->fio;
$this->params['breadcrumbs'][] = ['label' => 'Организаторы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="organizer-view">

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
            'fio',
            'email:email',
            'phone',
            [
                'format'=>'raw',
                'label'=>'Мероприятия',
                'value'=>function($model){
                    return implode('<br/>',$model->getSelectedEventsName());
                }
            ],
        ],
    ]) ?>

</div>
