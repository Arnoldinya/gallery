<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\Photo;

/**
 * PhotoController
 */
class PhotoController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create-update', 'delete'],
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
     * Добавить\редактировать фото
     * @return mixed
     */
    public function actionCreateUpdate($id = false)
    {
        if (Yii::$app->user->identity->gallery)
        {
            $photo = $id ? $this->findModel($id) : new Photo(['galleryId' => Yii::$app->user->identity->gallery->id]);

            if ($photo->galleryId == Yii::$app->user->identity->gallery->id)
            {
                if ($photo->load(Yii::$app->request->post()))
                {
                    $photo->file = UploadedFile::getInstance($photo, 'file');
                    if ($photo->file)
                    {
                        if ($photo->upload())
                        {
                            $photo->save(false);
                            return $this->redirect(['/gallery/index']);
                        }
                    }
                    else
                    {
                        if($photo->save())
                        {
                            return $this->redirect(['/gallery/index']);
                        }
                    }
                }

                return $this->render('create', [
                    'photo' => $photo,
                ]);
            }
            else
            {
                return $this->redirect(['/gallery/index']);
            }
        }
        else
        {
            return $this->redirect(['/gallery/create-update']);
        }
    }


    /**
     * Удалить фото
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $photo = $this->findModel($id);
        if ($photo->galleryId == Yii::$app->user->identity->gallery->id)
        {
            $photo->delete();
        }

        return $this->redirect(['/gallery/index']);
    }

    /**
     * Finds the Photo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Photo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Photo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
