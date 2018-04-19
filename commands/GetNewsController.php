<?php

namespace app\commands;

use app\models\News;
use app\models\Tags;
use yii\console\Controller;
use yii\console\ExitCode;

class GetNewsController extends Controller
{
    public function actionIndex()
    {
        $response = News::getNews();

        if($response === false) {
            echo "Something wrong with get news.";

            return ExitCode::OK;
        }

        echo "Количество добавленных новостей: " . $response->postsAdded;

        echo "\nГенерация тегов успешно завершена.";

        return ExitCode::OK;
    }
}