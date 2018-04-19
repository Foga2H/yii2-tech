<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'News';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <p>
        <?php

        use lo\widgets\modal\ModalAjax;

        echo ModalAjax::widget([
            'id' => 'createNews',
            'header' => 'Create News',
            'toggleButton' => [
                'label' => 'New Post',
                'class' => 'btn btn-primary pull-right'
            ],
            'url' => \yii\helpers\Url::to(['/news/create']), // Ajax view with form to load
            'ajaxSubmit' => true, // Submit the contained form as ajax, true by default

            'options' => ['class' => 'header-primary'],
            'autoClose' => true,
            'pjaxContainer' => '#grid-news-pjax',

        ]);

        ?>
    </p>

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'description:ntext',
            'source_id',
            'source_name:ntext',

            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['class' => 'editButtons']
            ],
        ],
    ]); ?>

    <?php

    echo ModalAjax::widget([
        'id' => 'updateNews',
        'selector' => '.editButtons a', // all buttons in grid view with href attribute
        'ajaxSubmit' => true, // Submit the contained form as ajax, true by default

        'options' => ['class' => 'header-primary'],
        'pjaxContainer' => '#grid-news-pjax',
        'events'=>[
            ModalAjax::EVENT_MODAL_SHOW => new \yii\web\JsExpression("
            function(event, data, status, xhr, selector) {
                selector.addClass('warning');
            }
       "),
            ModalAjax::EVENT_MODAL_SUBMIT => new \yii\web\JsExpression("
            function(event, data, status, xhr, selector) {
                if(status){

                    alert('Успешно обновлено.');

                    $(this).modal('toggle');
                }
            }
        ")
        ]

    ]);

    ?>
</div>
