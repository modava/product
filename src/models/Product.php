<?php

namespace modava\product\models;

use common\helpers\MyHelper;
use common\models\User;
use modava\product\components\MyUpload;
use modava\product\models\table\ProductTable;
use modava\product\ProductModule;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\db\ActiveRecord;


class Product extends ProductTable
{
    public $toastr_key = 'product';
    public $iptImages;

    public function behaviors()
    {

        return array_merge(
            parent::behaviors(),
            [
                'slug' => [
                    'class' => SluggableBehavior::class,
                    'immutable' => false,
                    'ensureUnique' => true,
                    'value' => function () {
                        return MyHelper::createAlias($this->title);
                    }
                ],
                [
                    'class' => BlameableBehavior::class,
                    'createdByAttribute' => 'created_by',
                    'updatedByAttribute' => 'updated_by',
                ],
                'timestamp' => [
                    'class' => 'yii\behaviors\TimestampBehavior',
                    'preserveNonEmptyValues' => true,
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                        ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                    ],
                ],
                [
                    'class' => AttributeBehavior::class,
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => ['type_id'],
                        ActiveRecord::EVENT_BEFORE_UPDATE => ['type_id'],
                    ],
                    'value' => function () {
                        if ($this->type_id == null) return 0;
                        return $this->type_id;
                    }
                ]
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['category_id', 'type_id', 'position', 'status', 'product_hot', 'views', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['description', 'content', 'ads_pixel', 'ads_session', 'language'], 'string'],
            [['product_tech', 'iptImages'], 'safe'],
            ['language', 'in', 'range' => ['vi', 'en', 'jp'], 'strict' => false],
            [['product_code'], 'string', 'max' => 25],
            [['title', 'slug', 'image', 'price', 'price_sale', 'so_luong'], 'string', 'max' => 255],
            [['slug'], 'unique', 'targetAttribute' => 'slug'],
            ['image', 'file', 'extensions' => ['png', 'jpg', 'gif', 'jpeg'],
                'maxSize' => 1024 * 1024],
            ['product_code', 'unique', 'targetAttribute' => 'product_code', 'message' => ProductModule::t('product', 'Mã sản phẩm đã tồn tại')],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductCategory::class, 'targetAttribute' => ['category_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductType::class, 'targetAttribute' => ['type_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => ProductModule::t('product', 'ID'),
            'product_code' => ProductModule::t('product', 'Product Code'),
            'category_id' => ProductModule::t('product', 'Category ID'),
            'type_id' => ProductModule::t('product', 'Type ID'),
            'title' => ProductModule::t('product', 'Title'),
            'slug' => ProductModule::t('product', 'Slug'),
            'image' => ProductModule::t('product', 'Image'),
            'price' => ProductModule::t('product', 'Price'),
            'price_sale' => ProductModule::t('product', 'Price Sale'),
            'so_luong' => ProductModule::t('product', 'Quantity'),
            'description' => ProductModule::t('product', 'Description'),
            'content' => ProductModule::t('product', 'Content'),
            'product_hot' => ProductModule::t('product', 'Product hot'),
            'product_tech' => ProductModule::t('product', 'Product tech'),
            'position' => ProductModule::t('product', 'Position'),
            'ads_pixel' => ProductModule::t('product', 'Ads Pixel'),
            'ads_session' => ProductModule::t('product', 'Ads Session'),
            'status' => ProductModule::t('product', 'Status'),
            'views' => ProductModule::t('product', 'Views'),
            'language' => ProductModule::t('product', 'Language'),
            'created_at' => ProductModule::t('product', 'Created At'),
            'updated_at' => ProductModule::t('product', 'Updated At'),
            'created_by' => ProductModule::t('product', 'Created By'),
            'updated_by' => ProductModule::t('product', 'Updated By'),
        ];
    }

    public function validateImages()
    {
        $iptImages = json_decode($this->iptImages);
        if ($iptImages != null) {
            $this->iptImages = $iptImages;
        }
        if ($this->iptImages == null) {
            $this->addError('iptImages', 'Images null');
            return false;
        } else {
            if (is_string($this->iptImages)) $this->iptImages = [$this->iptImages];
            if (!is_array($this->iptImages)) {
                $this->addError('iptImages', 'Data type failed');
                return false;
            } else {
                foreach ($this->iptImages as $image) {
                    $modelImages = new ProductImage([
                        'product_id' => $this->primaryKey,
                        'image_url' => $image
                    ]);
                    if (!$modelImages->validate()) {
                        var_dump($modelImages->getErrors());
                        return false;
                    }
                }
            }
        }
        return true;
    }

    public function saveImages()
    {
        if (is_array($this->iptImages)) {
            foreach ($this->iptImages as $image) {
                $path = Yii::getAlias('@frontend/web/uploads/product/');
                $imageName = null;
                foreach (Yii::$app->params['product'] as $key => $value) {
                    $pathSave = $path . $key;
                    if (!file_exists($pathSave) && !is_dir($pathSave)) {
                        mkdir($pathSave);
                    }
                    $resultName = MyUpload::uploadFromOnline($value['width'], $value['height'], $image, $pathSave . '/', $imageName);
                    if ($imageName == null) {
                        $imageName = $resultName;
                    }
                }
                $modelImage = new ProductImage([
                    'product_id' => $this->primaryKey,
                    'image_url' => $imageName
                ]);
                if (!$modelImage->save()) {
                    var_dump($modelImage->getErrors());
                    return false;
                }
            }
        }
        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->on(yii\db\BaseActiveRecord::EVENT_AFTER_INSERT, function (yii\db\AfterSaveEvent $e) {
            if ($this->position == null)
                $this->position = $this->primaryKey;
            $this->save();
        });
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCreated()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[UpdatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserUpdated()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }
}
