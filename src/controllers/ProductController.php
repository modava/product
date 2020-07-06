<?php

namespace modava\product\controllers;

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
use yii\db\Exception;

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
            if ($model->validate()) {
                if ($model->save()) {
                    if ($model->image != "") {
                        $pathImage = FRONTEND_HOST_INFO . $model->image;
                        $path = Yii::getAlias('@frontend/web/uploads/product/');
                        $imageName = null;
                        foreach (Yii::$app->params['product'] as $key => $value) {
                            $pathSave = $path . $key;
                            if (!file_exists($pathSave) && !is_dir($pathSave)) {
                                mkdir($pathSave);
                            }
                            $imageName = MyUpload::uploadFromOnline($value['width'], $value['height'], $pathImage, $pathSave . '/', $imageName);
                        }

                    } else {
                        $imageName = NOIMAGE;
                    }
                    $model->image = $imageName;
                    $model->updateAttributes(['image']);
                    Yii::$app->session->setFlash('toastr-product-view', [
                        'text' => 'Tạo mới thành công',
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
                $oldImage = $model->getOldAttribute('image');
                if ($model->save()) {
                    if ($model->getAttribute('image') !== $oldImage) {
                        if ($model->getAttribute('image') == '') {
                            $model->image = 'no-image.png';
                            $model->updateAttributes(['image']);
                        } else {
                            $pathImage = FRONTEND_HOST_INFO . $model->image;
                            $path = Yii::getAlias('@frontend/web/uploads/product/');
                            $imageName = null;
                            foreach (Yii::$app->params['product'] as $key => $value) {
                                $pathSave = $path . $key;
                                if (!file_exists($pathSave) && !is_dir($pathSave)) {
                                    mkdir($pathSave);
                                }
                                $resultName = MyUpload::uploadFromOnline($value['width'], $value['height'], $pathImage, $pathSave . '/', $imageName);
                                if ($imageName == null) {
                                    $imageName = $resultName;
                                }
                            }

                            $model->image = $imageName;
                            if ($model->updateAttributes(['image'])) {
                                foreach (Yii::$app->params['product'] as $key => $value) {
                                    $pathSave = $path . $key;
                                    if (file_exists($pathSave . '/' . $oldImage) && $oldImage != null) {
                                        unlink($pathSave . '/' . $oldImage);
                                    }

                                }
                            }
                        }
                    }
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
        $model = $this->findModel($id);
        try {
            if ($model->delete()) {
                Yii::$app->session->setFlash('toastr-' . $model->toastr_key . '-index', [
                    'title' => 'Thông báo',
                    'text' => 'Xoá thành công',
                    'type' => 'success'
                ]);
            } else {
                $errors = Html::tag('p', 'Xoá thất bại');
                foreach ($model->getErrors() as $error) {
                    $errors .= Html::tag('p', $error[0]);
                }
                Yii::$app->session->setFlash('toastr-' . $model->toastr_key . '-index', [
                    'title' => 'Thông báo',
                    'text' => $errors,
                    'type' => 'warning'
                ]);
            }
        } catch (Exception $ex) {
            Yii::$app->session->setFlash('toastr-' . $model->toastr_key . '-index', [
                'title' => 'Thông báo',
                'text' => Html::tag('p', 'Xoá thất bại: ' . $ex->getMessage()),
                'type' => 'warning'
            ]);
        }
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

    public function actionGetProductInfo($id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $product = ProductTable::getById($id);
            if ($product != null) return [
                'code' => 200,
                'data' => $product->getAttributes([
                    'title', 'price', 'price_sale'
                ])
            ];
        }
        return [
            'code' => 403,
            'data' => ProductModule::t('product', 'Permission denined!')
        ];
    }
}
