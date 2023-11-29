<?php

use app\models\Event;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var app\models\Organizer $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="organizer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?php /* $form->field($model, 'events')->dropDownList(Event::getAllArray(), [
        'multiple' => true,
    ]) */ ?>
    <?php /* $form->field($model, 'events')->widget(Select2::class,[
        'data' => Event::getAllArray(),
        'language' => 'ru',
        'options' => ['placeholder' => 'мероприятия'],
        'pluginOptions' => [
            'allowClear' => true,
            'multiple' => true,
        ],
    ]); */ ?>

    <?= $form->field($model, 'events')->widget(Select2::class, [
        'data' => $model->getSelectedEventsName(),
        'options' => [
            'placeholder' => 'мероприятия',
            'multiple' => true,
        ],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 1,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'Подождите...'; }"),
            ],
            'ajax' => [
                'url' => Url::to(['/admin/organizer/events']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) {return {q:params.term}; }'),
                'delay' => 250,
                'cache' => true,
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(data) {return data.text; }'),
            'templateSelection' => new JsExpression('function (data) {  return data.text; }'),
        ],
    ]); ?>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
