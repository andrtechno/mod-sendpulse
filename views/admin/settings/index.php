<?php

use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;
?>
<?php
$form = ActiveForm::begin([
]);
?>
<div class="card bg-light">
    <div class="card-header">
        <?= $this->context->pageName ?>
    </div>
    <div class="card-body">
        <?= $form->field($model, 'api_id')->textInput(['maxlength'=>32]); ?>
        <?= $form->field($model, 'api_secret')->textInput(['maxlength'=>32]); ?>
        <?= $form->field($model, 'website_id'); ?>
        <?= $form->field($model, 'push_ttl'); ?>
    </div>
    <div class="card-footer text-center">
        <?= Html::submitButton(Yii::t('app', 'SAVE'), ['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>