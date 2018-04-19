<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TagsBlacklist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tags-blacklist-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">

        <?= $form->field($model, 'tag')->textInput() ?>

        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
