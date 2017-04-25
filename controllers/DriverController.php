<?php

namespace app\controllers;

use Yii;
use app\models\Driver;
use app\models\DriverSearch;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * DriverController implements the CRUD actions for Driver model.
 */
class DriverController extends Controller
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
     * Lists all Driver models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DriverSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Driver model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Update active Driver model.
     * @param integer $id
     * @return mixed
     */
    public function actionActive(int $id,int $active)
    {
        $model = Driver::findOne($id);
        $model->active = $active;
        $model->save();
        return true;
    }

    /**
     * Get time.
     * @param integer $id
     * @param float $distance
     * @return string
     */
    public function actionTime(int $id,float $distance)
    {
        $html = '';
        $bus = Driver::getDriverBus($id);
        $time = $distance / $bus->average_speed;
        if ($time > 8):
            $day = intval($time / 8);
            $time = $time - ($day * 8);
            $hour = intval(($time * 60) / 60);
            $time = ($time - $hour) * 60;
            $html .= $day . ' дней, ' . $hour . ' часов, ' . $time . ' минут';
        else:
            $hour = intval($distance / $bus->average_speed);
            $time = ($time - $hour) * 60;
            $html .= $hour . ' часов, ' . $time . ' минут';
        endif;
        return json_encode([
            'html' => $html,
            'id' => $id
        ]);
    }

    /**
     * Creates a new Driver model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Driver();

        if ($model->load(Yii::$app->request->post())):
            $file = UploadedFile::getInstance($model, 'photo');
            if ($file && $file->tempName):
                $model->photo = $file;
                if ($model->validate(['photo'])):
                    $dir = Yii::getAlias('@upload').'/';
                    $fileName = $model->photo->baseName.'.'.$model->photo->extension;
                    $model->photo->saveAs($dir.$fileName,true);
                    $model->photo = $fileName;
                    if ($model->save()) return $this->redirect(['view', 'id' => $model->id]);
                else
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                endif;
            endif;
        else:
            return $this->render('create', [
                'model' => $model,
            ]);
        endif;
    }

    /**
     * Updates an existing Driver model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Driver model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Driver model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Driver the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Driver::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Check access before action.
     * @param mixed $action
     * @return mixed
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)):
            if (!Yii::$app->user->can($action->id))
                throw new ForbiddenHttpException('Access denied');
            return true;
        else:
            return false;
        endif;
    }
}
