<?php

namespace app\modules\admin\controllers;

use app\models\Event2organizer;
use app\models\Organizer;
use app\models\OrganizerSearch;

use Yii;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * OrganizerController implements the CRUD actions for Organizer model.
 */
class OrganizerController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionEvents() {

        Yii::$app->response->format = Response::FORMAT_JSON;

        $q = Yii::$app->request->get('q');
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = (new Query)
                ->select('id AS id, CONCAT_WS(" ",`date` ,`name`) AS text')
                ->from('events')
                ->where(['like', 'date', $q])
                ->orWhere(['like', 'name', $q]);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        return $out;
    }

    /**
     * Lists all Organizer models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OrganizerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Organizer model.
     * @param int $id Ид
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Organizer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Organizer();
        $model->events = [];

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Organizer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id Ид
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->events = $model->getSelectedEventsIds();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            $post = $this->request->post();
            $events = $post['Organizer']['events'];
            $model->eventsSave($events);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Organizer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id Ид
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $transaction = Yii::$app->db->beginTransaction();
        try {
            Event2organizer::deleteAll([
                'organizer_id'=>$model->id,
            ]);
            $model->delete();
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Organizer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id Ид
     * @return Organizer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Organizer::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
