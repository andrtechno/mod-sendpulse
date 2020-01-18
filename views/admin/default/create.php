<?php

use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;
use panix\engine\jui\DatetimePicker;
?>
<?php
$form = ActiveForm::begin([
]);
?>
<div class="card bg-light">
    <div class="card-header">
        <h5><?= $this->context->pageName ?></h5>
    </div>
    <div class="card-body">
        <?= $form->field($model, 'title')->textInput(['maxlength'=>50]); ?>
        <?= $form->field($model, 'body')->textarea(['maxlength'=>125]); ?>
        <?= $form->field($model, 'link')->textInput(['maxlength'=>255]); ?>
        <?= $form->field($model, 'send_date')->widget(DatetimePicker::class,[])->textInput(['maxlength' => 19]) ?>
        <?= $form->field($model, 'button1_text')->textInput(['maxlength'=>50])->hint('Данные функции работают не во всех браузерах (только Chrome/Chromium)'); ?>
        <?= $form->field($model, 'button1_link')->textInput(['maxlength'=>50])->hint('Данные функции работают не во всех браузерах (только Chrome/Chromium)'); ?>
        <?= $form->field($model, 'button2_text')->textInput(['maxlength'=>50])->hint('Данные функции работают не во всех браузерах (только Chrome/Chromium)'); ?>
        <?= $form->field($model, 'button2_link')->textInput(['maxlength'=>50])->hint('Данные функции работают не во всех браузерах (только Chrome/Chromium)'); ?>
    </div>
    <div class="card-footer text-center">
        <?= Html::submitButton(Yii::t('app/default', 'SEND'), ['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>