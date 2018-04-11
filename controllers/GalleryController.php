<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Gallery;
use app\models\search\PhotoSearch;

/**
 * GalleryController
 */
class GalleryController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create-update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Список фото в галерее
     * @return mixed
     */
    public function actionIndex($id = false)
    {
        $gallery = $id ? $this->findModel($id) : Gallery::findOne(['userId' => Yii::$app->user->id]);

        if(!$gallery && $id && $id != Yii::$app->user->id)
        {
            return $this->redirect(['/site/index']);
        }

        return $this->render('index', [
            'gallery' => $gallery,
        ]);
    }

    /**
     * Добавить\редактировать галерею
     * @return mixed
     */
    public function actionCreateUpdate($id = false)
    {
        $gallery = $id ? $this->findModel($id) : new Gallery(['userId' => Yii::$app->user->id]);

        if ($gallery->userId == Yii::$app->user->id)
        {
            if ($gallery->load(Yii::$app->request->post()) && $gallery->save())
            {
                return $this->redirect(['index']);
            }

            return $this->render('create', [
                'gallery' => $gallery,
            ]);
        }
        else
        {
            return $this->redirect(['index']);
        }
    }

    /**
     * Удалить галерею
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $gallery = $this->findModel($id);

        if ($gallery->userId == Yii::$app->user->id)
        {
            $gallery->delete();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Gallery model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Gallery the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Gallery::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
