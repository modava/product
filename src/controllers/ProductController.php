<?php

namespace modava\product\controllers;

use modava\article\models\table\ActicleCategoryTable;
use modava\article\models\table\ArticleTypeTable;
use modava\product\components\MyUpload;
use modava\product\models\table\ProductCategoryTable;
use modava\product\models\table\ProductTable;
use modava\product\models\table\ProductTypeTable;
use modava\product\ProductModule;
use Yii;
use modava\product\models\Product;
use modava\product\models\search\ProductSearch;
use modava\product\components\MyProductController;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends MyProductController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate() && $model->save()) {
                if ($model->image != "") {
                    $pathImage = FRONTEND_HOST_INFO . $model->image;
                    $pathSave = Yii::getAlias('@frontend/web/uploads/product/');
                    $pathUpload = MyUpload::upload(200, 200, $pathImage, $pathSave);
                    $model->image = explode('frontend/web', $pathUpload)[1];
                } else {
                    $model->image = NOIMAGE;
                }
                $model->updateAttributes(['image']);
                Yii::$app->session->setFlash('toastr-product-view', [
                    'text' => 'Tạo mới thành công',
                    'type' => 'success'
                ]);
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $errors = '';
                foreach ($model->getErrors() as $error) {
                    $errors .= Html::tag('p', $error[0]);
                }
                Yii::$app->session->setFlash('toastr-product-form', [
                    'title' => 'Cập nhật thất bại',
                    'text' => $errors,
                    'type' => 'warning'
                ]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->getAttribute('image') != $model->getOldAttribute('image')) {
                    $pathImage = FRONTEND_HOST_INFO . $model->image;
                    $pathSave = Yii::getAlias('@frontend/web/uploads/product/');
                    $pathUpload = MyUpload::upload(200, 200, $pathImage, $pathSave);
                    $model->image = explode('frontend/web', $pathUpload)[1];
                }
                if ($model->save()) {
                    Yii::$app->session->setFlash('toastr-product-view', [
                        'text' => 'Cập nhật thành công',
                        'type' => 'success'
                    ]);
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                $errors = '';
                foreach ($model->getErrors() as $error) {
                    $errors .= Html::tag('p', $error[0]);
                }
                Yii::$app->session->setFlash('toastr-product-form', [
                    'title' => 'Cập nhật thất bại',
                    'text' => $errors,
                    'type' => 'warning'
                ]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Product model.
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
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(ProductModule::t('product', 'The requested page does not exist.'));
    }

    public function actionLoadCategoriesByLang($lang = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ArrayHelper::map(ProductCategoryTable::getAllProductCategory($lang), 'id', 'title');
    }

    public function actionLoadTypesByLang($lang = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ArrayHelper::map(ProductTypeTable::getAllProductType($lang), 'id', 'title');
    }
}
