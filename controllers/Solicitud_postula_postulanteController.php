<?php

namespace app\controllers;

use Yii;
use app\models\MYSQLSolicitud_postula_postulante;
use app\models\MYSQLSolicitud_postula_postulanteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Solicitud_postula_postulanteController implements the CRUD actions for MYSQLSolicitud_postula_postulante model.
 */
class Solicitud_postula_postulanteController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all MYSQLSolicitud_postula_postulante models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MYSQLSolicitud_postula_postulanteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MYSQLSolicitud_postula_postulante model.
     * @param integer $solicitud_id
     * @param integer $postulante_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($solicitud_id, $postulante_id)
    {
        return $this->render('view', [
        'model' => $this->findModel($solicitud_id, $postulante_id),
    ]);
}

    /**
     * Creates a new MYSQLSolicitud_postula_postulante model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MYSQLSolicitud_postula_postulante();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'solicitud_id' => $model->solicitud_id, 'postulante_id' => $model->postulante_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MYSQLSolicitud_postula_postulante model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $solicitud_id
     * @param integer $postulante_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($solicitud_id, $postulante_id)
    {
        $model = $this->findModel($solicitud_id, $postulante_id);

        if ($model->solicitud->load(Yii::$app->request->post('MYSQLSolicitudInscripcion'),"") && $model->solicitud->save(false)) {
           
            return $this->redirect(['view','solicitud_id' => $model->solicitud_id, 'postulante_id' => $model->postulante_id]);
        }
            
        
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MYSQLSolicitud_postula_postulante model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $solicitud_id
     * @param integer $postulante_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($solicitud_id, $postulante_id)
    {
        $this->findModel($solicitud_id, $postulante_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MYSQLSolicitud_postula_postulante model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $solicitud_id
     * @param integer $postulante_id
     * @return MYSQLSolicitud_postula_postulante the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($solicitud_id, $postulante_id)
    {
        if (($model = MYSQLSolicitud_postula_postulante::findOne(['solicitud_id'=>$solicitud_id,'postulante_id'=>$postulante_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
