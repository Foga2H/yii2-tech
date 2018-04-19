<?php

namespace app\controllers;

use app\models\Tags;
use app\models\TagsHistory;

class StatsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $tags_history = TagsHistory::find()->all();

        $days = [];

        foreach($tags_history as $tag_history) {
            $created = \DateTime::createFromFormat('Y-m-d H:i:s', $tag_history->created_at)->format('d M Y');

            if(!in_array($created, $days)) {
                $days[] = $created;
            }
        }

        $datasets = [];
        $tags = Tags::find()->all();

        $topTags = [];
        $formattedTags = [];

        foreach($tags as $tag) {
            $count = 0;

            $tagHistory = TagsHistory::find()->where(['=', 'tag_id', $tag->id])->all();

            foreach ($tagHistory as $item) {
                $count = ($count+$item->count);
            }

            $topTagItem = [];
            $topTagItem['tag'] = $tag;
            $topTagItem['count'] = $count;

            $formattedTags[] = $topTagItem;
        }

        usort($formattedTags, function($a, $b) {
            if ($a['count'] == $b['count']) {
                return 0;
            }

            return ($a['count'] > $b['count']) ? -1 : 1;
        });

        $iteration = 0;
        foreach ($formattedTags as $item) {
            if($iteration < 10) {

                $topTags[] = $item['tag'];

                $iteration++;
            }
        }

        foreach ($topTags as $tag) {
            $data = [];

            foreach($days as $day) {
                $item = TagsHistory::find()->where("DATE(created_at) = '" . $day . "'")->andWhere(['=', 'tag_id', $tag->id])->one();

                if(is_null($item)) {
                    $item = 0;
                } else {
                    $item = $item->count;
                }

                $data[] = $item;
            }

            $datasets[] = [
                'label' => $tag->tag,
                'backgroundColor' => "rgba(".rand(0,255).",".rand(0,255).",198,0.2)",
                'borderColor' => "rgba(".rand(0,255).",".rand(0,255).",198,1)",
                'pointBackgroundColor' => "rgba(".rand(0,255).",".rand(0,255).",198,1)",
                'pointBorderColor' => "#fff",
                'pointHoverBackgroundColor' => "#fff",
                'pointHoverBorderColor' => "rgba(".rand(0,255).",".rand(0,255).",198,1)",
                'data' => $data
            ];
        }

        return $this->render('index', [
            'days' => $days,
            'datasets' => $datasets
        ]);
    }

}
