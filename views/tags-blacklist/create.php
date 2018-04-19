<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TagsBlacklist */

$this->title = 'Create Tags Blacklist';
$this->params['breadcrumbs'][] = ['label' => 'Tags Blacklists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tags-blacklist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
