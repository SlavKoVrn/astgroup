<?php
use app\models\Organizer;

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Event $model */
/** @var yii\widgets\ActiveForm $form */
?>
<div class="event-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date')->widget(DatePicker::class,([
        'language' => 'ru',
        'model' => $model,
        'attribute' => 'date',
        'options' => ['class' => 'form-control'],
        'dateFormat' => 'dd.MM.yyyy',
    ])); ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?php /* $form->field($model, 'organizers')->dropDownList(Organizer::getAllArray(), [
        'multiple' => true,
    ]) */ ?>
    <?php /* $form->field($model, 'organizers')->widget(Select2::class,[
        'data' => Organizer::getAllArray(),
        'language' => 'ru',
        'options' => ['placeholder' => 'организаторы'],
        'pluginOptions' => [
            'allowClear' => true,
            'multiple' => true,
        ],
    ]);*/?>

    <?= $form->field($model, 'organizers')->widget(Select2::class, [
        'data' => $model->getSelectedOrganizersName(),
        'options' => [
            'placeholder' => 'организаторы',
            'multiple' => true,
         ],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 1,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'Подождите...'; }"),
            ],
            'ajax' => [
                'url' => Url::to(['/admin/event/organizers']),
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
