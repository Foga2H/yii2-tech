<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $url
 * @property string $urlToImage
 * @property string $source_id
 * @property string $source_name
 */
class News extends \yii\db\ActiveRecord
{
    const BASE_URL = "http://newsapi.org/v2/everything";
    const API_KEY = "73b98def7e5e48a9a3aa822409362ba7";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'url', 'urlToImage', 'source_name'], 'string'],
            [['title', 'source_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'url' => 'Url',
            'urlToImage' => 'Url To Image',
            'source_id' => 'Source ID',
            'source_name' => 'Source Name',
        ];
    }

    public static function getNews()
    {
        $news = @file_get_contents(self::BASE_URL . "?q=VPN&apiKey=" . self::API_KEY);

        if($news === false) {
            return false;
        }

        $news = json_decode($news)->articles;
        $data = News::addNews($news);

        $tags = Tags::generateTags($data->newsAdded);

        return $data;
    }

    public static function createPost($post)
    {
        $article = new News();
        $article->title = $post->title;
        $article->description = $post->description;
        $article->url = $post->url;
        $article->urlToImage = $post->urlToImage;
        $article->source_id = $post->source->id;
        $article->source_name = $post->source->name;
        $article->save();

        return $article;
    }

    public static function addNews(array $news)
    {
        $postsAdded = 0;
        $newsAdded = [];

        foreach($news as $post) {
            if(!static::find()->where(['url' => $post->url])->one()) {
                $article = self::createPost($post);

                $newsAdded[] = $article;
                $postsAdded++;
            }
        }

        $response = (object) [];
        $response->postsAdded = $postsAdded;
        $response->newsAdded = $newsAdded;

        return $response;
    }
}
