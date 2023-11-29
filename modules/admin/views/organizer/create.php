<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Organizer $model */

$this->title = 'Добавить организатора';
$this->params['breadcrumbs'][] = ['label' => 'Организаторы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organizer-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
