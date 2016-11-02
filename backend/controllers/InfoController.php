<?php

namespace backend\controllers;

use Yii;
use backend\models\Info;
use backend\models\InfoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Region;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
/**
 * InfoController implements the CRUD actions for Info model.
 */
class InfoController extends Controller
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
     * Lists all Info models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Info model.
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
     * Creates a new Info model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Info();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Info model.
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
     * Deletes an existing Info model.
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
     * Finds the Info model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Info the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Info::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     *@FUNCNAME:actionCities;
     *@AUTHOR:dudongjiang;
     *@DATE:2016年11月2日;
     *@EFFORT:获取城市信息;
     **/
    public function actionCities($provinceId,$selection = null)
    {
        $cities = Region::findAllCities($provinceId);
        $tagOptions = [
            'prompt' => '请选择城市'
        ];
        echo Html::renderSelectOptions($selection,ArrayHelper::map($cities,'region_id','region_name'),$tagOptions);
    }
    /**
     *@FUNCNAME:actionDistricts;
     *@AUTHOR:dudongjiang;
     *@DATE:2016年11月2日;
     *@EFFORT:获取区域信息;
     **/
    public function actionDistincts($cityId,$selection = null)
    {
        $districts = Region::findAllDistincts($cityId);
        $tagOptions = [
            'prompt' => '请选择地区'
        ];
        echo Html::renderSelectOptions($selection,ArrayHelper::map($districts,'region_id','region_name'),$tagOptions);
    }
}
