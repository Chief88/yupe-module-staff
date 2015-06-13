<?php
/**
 * Class Staff
 */
class Staff extends yupe\models\YModel
{

    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_MODERATION = 2;

    const PROTECTED_NO = 0;
    const PROTECTED_YES = 1;

    const NO_INDEX_NO = 0;
    const NO_INDEX_YES = 1;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{article_article}}';
    }

    /**
     * Returns the static model of the specified AR class.
     * @param  string $className
     * @return article   the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id'            => Yii::t('ArticleModule.article', 'Id'),
            'category_id'   => Yii::t('ArticleModule.article', 'Category'),
            'creation_date' => Yii::t('ArticleModule.article', 'Created at'),
            'change_date'   => Yii::t('ArticleModule.article', 'Updated at'),
            'date'          => Yii::t('ArticleModule.article', 'Date'),
            'title'         => Yii::t('ArticleModule.article', 'Title'),
            'alias'         => Yii::t('ArticleModule.article', 'Alias'),
            'image'         => Yii::t('ArticleModule.article', 'Image'),
            'link'          => Yii::t('ArticleModule.article', 'Link'),
            'lang'          => Yii::t('ArticleModule.article', 'Language'),
            'short_text'    => Yii::t('ArticleModule.article', 'Short text'),
            'full_text'     => Yii::t('ArticleModule.article', 'Full text'),
            'user_id'       => Yii::t('ArticleModule.article', 'Author'),
            'status'        => Yii::t('ArticleModule.article', 'Status'),
            'is_protected'  => Yii::t('ArticleModule.article', 'Access only for authorized'),
            'seo_keywords'      => Yii::t('ArticleModule.article', 'seo_keywords (SEO)'),
            'seo_description'   => Yii::t('ArticleModule.article', 'seo_description (SEO)'),
            'name_author'   => Yii::t('ArticleModule.article', 'Name author'),
            'video_url'   => Yii::t('ArticleModule.article', 'Video url'),
            'page_title'   => Yii::t('ArticleModule.article', 'Page title'),
            'no_index'          => Yii::t('ArticleModule.article', 'No index'),
            'sort'          => Yii::t('ArticleModule.article', 'sort'),
        ];
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['title, alias, short_text, full_text, seo_keywords, seo_description', 'filter', 'filter' => 'trim'],
            ['title, alias, seo_keywords, seo_description', 'filter', 'filter' => [new CHtmlPurifier(), 'purify']],
            ['date, alias, full_text', 'required', 'on' => ['update', 'insert']],
            ['sort, no_index, status, is_protected, category_id', 'numerical', 'integerOnly' => true],
            ['title, alias', 'length', 'max' => 150],
            ['lang', 'length', 'max' => 2],
            ['lang', 'default', 'value' => Yii::app()->sourceLanguage],
            ['lang', 'in', 'range' => array_keys(Yii::app()->getModule('yupe')->getLanguagesList())],
            ['status', 'in', 'range' => array_keys($this->getStatusList())],
            ['alias', 'yupe\components\validators\YUniqueSlugValidator'],
            ['seo_description, seo_keywords, page_title, name_author, link', 'length', 'max' => 250],
            ['video_url', 'length', 'max' => 500],
            ['video_url', 'yupe\components\validators\YUrlValidator'],
            [
                'alias',
                'yupe\components\validators\YSLugValidator',
                'message' => Yii::t('ArticleModule.article', 'Bad characters in {attribute} field')
            ],
            ['category_id', 'default', 'setOnEmpty' => true, 'value' => null],
            [
                'sort, no_index, page_title, id, seo_keywords, seo_description, creation_date, change_date, date, title, alias, short_text, full_text, user_id, status, is_protected, lang',
                'safe',
                'on' => 'search'
            ],
        ];
    }

    public function behaviors()
    {
        $module = Yii::app()->getModule('article');

        return [
            'imageUpload' => [
                'class'         => 'yupe\components\behaviors\ImageUploadBehavior',
                'scenarios'     => ['insert', 'update'],
                'attributeName' => 'image',
                'minSize'       => $module->minSize,
                'maxSize'       => $module->maxSize,
                'types'         => $module->allowedExtensions,
                'uploadPath'    => $module->uploadPath,
                'fileName'      => [$this, 'generateFileName'],
            ],
        ];
    }

    public function generateFileName()
    {
        return md5($this->title . microtime(true) . uniqid());
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'category' => [self::BELONGS_TO, 'Category', 'category_id'],
            'user'     => [self::BELONGS_TO, 'User', 'user_id'],
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria();

        $criteria->compare('t.id', $this->id);
        $criteria->compare('creation_date', $this->creation_date, true);
        $criteria->compare('change_date', $this->change_date, true);
        if ($this->date) {
            $criteria->compare('date', date('Y-m-d', strtotime($this->date)));
        }
        $criteria->compare('title', $this->title, true);
        $criteria->compare('t.alias', $this->alias, true);
        $criteria->compare('short_text', $this->short_text, true);
        $criteria->compare('full_text', $this->full_text, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('category_id', $this->category_id, true);
        $criteria->compare('is_protected', $this->is_protected);
        $criteria->compare('t.lang', $this->lang);
        $criteria->compare('t.no_index', $this->no_index);
        $criteria->compare('t.sort', $this->sort);
        $criteria->with = ['category'];

        return new CActiveDataProvider(get_class($this), [
            'criteria' => $criteria,
            'sort'     => ['defaultOrder' => 't.sort']
        ]);
    }

    public function getPositionName()
    {
        return ($this->position === null) ? '---' : $this->position->name;
    }

    public function sort(array $items){

        $transaction = Yii::app()->db->beginTransaction();

        try {

            foreach ($items as $id => $priority) {

                $model = $this->findByPk($id);

                if (null === $model) {
                    continue;
                }

                $model->sort = (int)$priority;

                if (!$model->update('sort')) {
                    throw new CDbException('Error sort menu items!');
                }
            }

            $transaction->commit();

            return true;
        } catch (Exception $e) {
            $transaction->rollback();

            return false;
        }
    }
}
