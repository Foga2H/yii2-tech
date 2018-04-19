<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TagsBlacklist */

$this->title = 'Update Tags Blacklist';
$this->params['breadcrumbs'][] = ['label' => 'Tags Blacklists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tags-blacklist-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
