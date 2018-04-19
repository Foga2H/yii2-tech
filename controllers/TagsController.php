<?php

namespace app\controllers;

use app\models\TagsHistory;
use Yii;
use app\models\Tags;
use app\models\TagsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TagsController implements the CRUD actions for Tags model.
 */
class TagsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Tags models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TagsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tags model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $tags_history = TagsHistory::find()->all();

        $days = [];

        foreach($tags_history as $tag_history) {
            $created = \DateTime::createFromFormat('Y-m-d H:i:s', $tag_history->created_at)->format('d M Y');

            if(!in_array($created, $days)) {
                $days[] = $created;
            }
        }

        $data = [];

        $iteration = 0;
        foreach($days as $day) {
            $count = TagsHistory::find()->where("DATE(created_at) = '" . $day . "'")->andWhere(['=', 'tag_id', $id])->one();

            if(is_null($count)) {
                $count = 0;
            } else {
                $count = $count->count;
            }

            $dataItem = [];
            $dataItem['date'] = $day;
            $dataItem['count'] = $count;

            $diff = ($iteration != 0) ? ($count-$data[$iteration-1]['count']) : ' ';

            if($diff == 0) {
                $diff = ' ';
            } else {
                $diff = ($diff < 0) ? $diff : "+" . $diff;
            }

            $dataItem['diff'] = $diff;

            $data[] = $dataItem;
            $iteration++;
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
            'stats' => $data
        ]);
    }

    /**
     * Creates a new Tags model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tags();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Tags model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Tags model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tags model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tags the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tags::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
