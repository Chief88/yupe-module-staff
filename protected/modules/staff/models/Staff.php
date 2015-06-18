<?php
/**
 * Class Staff
 * @author Chief88 <serg.latyshkov@gmail.com>
 */
class Staff extends yupe\models\YModel
{
    private $_aliasModule = 'StaffModule.staff';
    
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{staff_staff}}';
    }

    /**
     * Returns the static model of the specified AR class.
     * @param  string $className
     * @return staff   the static model class
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
            'id'            => Yii::t($this->_aliasModule, 'Id'),
            'first_name'    => Yii::t($this->_aliasModule, 'First name'),
            'last_name'     => Yii::t($this->_aliasModule, 'Last name'),
            'patronymic'    => Yii::t($this->_aliasModule, 'Patronymic'),
            'image'         => Yii::t($this->_aliasModule, 'Image'),
            'data'          => Yii::t($this->_aliasModule, 'Data'),
            'sort'          => Yii::t($this->_aliasModule, 'Sort'),
        ];
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['first_name, last_name, patronymic, data', 'filter', 'filter' => 'trim'],
            ['first_name, last_name, patronymic', 'filter', 'filter' => [new CHtmlPurifier(), 'purify']],
            ['first_name, last_name, patronymic, image', 'required', 'on' => ['update', 'insert']],
            ['sort', 'numerical', 'integerOnly' => true],
            ['first_name, last_name, patronymic', 'length', 'max' => 150],
            [
                'sort, first_name, last_name, patronymic, image, data',
                'safe',
                'on' => 'search'
            ],
        ];
    }

    public function behaviors()
    {
        $module = Yii::app()->getModule('staff');

        return [
            'imageUpload' => [
                'class'         => 'yupe\components\behaviors\ImageUploadBehavior',
                'attributeName' => 'image',
                'minSize'       => $module->minSize,
                'maxSize'       => $module->maxSize,
                'types'         => $module->allowedExtensions,
                'uploadPath'    => $module->uploadPath,
                'resizeOptions' => [
                    'width'   => 9999,
                    'height'  => 9999,
                    'quality' => [
                        'jpegQuality'         => 100,
                        'pngCompressionLevel' => 10
                    ]
                ],
                'defaultImage'   => $module->getAssetsUrl() . '/img/nophoto.jpg'
            ],
            'sortable'             => [
                'class'         => 'yupe\components\behaviors\SortableBehavior',
                'attributeName' => 'sort'
            ]

        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [];
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
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('last_name', $this->last_name, true);
        $criteria->compare('patronymic', $this->patronymic, true);

        return new CActiveDataProvider(get_class($this), [
            'criteria' => $criteria,
            'sort'     => ['defaultOrder' => 't.sort']
        ]);
    }

}
