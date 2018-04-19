<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tags */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Tag: " . $model->tag;
$this->params['breadcrumbs'][] = ['label' => 'Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tags-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'tag',
            'updated_at',
            'created_at',
        ],
    ]) ?>

    <h1>Список новостей</h1>

    <?php

    $news_ids = [];

    foreach($model->getTagsToNews()->all() as $item) {
        $news_ids[] = $item->news_id;
    }

    $provider = new \yii\data\ArrayDataProvider([
        'allModels' => \app\models\News::findAll($news_ids),
        'pagination' => [
            'pageSize' => 10,
        ],
        'sort' => [
            'attributes' => ['id', 'title', 'description'],
        ],
    ]);

    ?>

    <?= \yii\grid\GridView::widget([
        'dataProvider' => $provider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'description',

            [
                'attribute' => '',
                'format' => 'raw',
                'value' => function ($model) {
                    return '<a href="' . \yii\helpers\Url::toRoute(['news/view', 'id' => $model->id]) . '"><span class="glyphicon glyphicon-eye-open"></span></a>';
                },
            ],
        ],
    ]); ?>

    <h1>Статистика</h1>

    <?php

    $provider = new \yii\data\ArrayDataProvider([
        'allModels' => $stats,
        'pagination' => [
            'pageSize' => 10,
        ],
        'sort' => [
            'attributes' => ['date', 'count', 'diff'],
        ],
    ]);

    ?>

    <?= \yii\grid\GridView::widget([
        'dataProvider' => $provider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'date',
            'count',
            'diff'
        ],
    ]); ?>

</div>
