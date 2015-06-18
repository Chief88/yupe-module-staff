<?php

use yupe\components\WebModule;

/**
 * Class StaffModule
 */

class StaffModule extends WebModule
{
    const VERSION = '0.9.6';

    public $uploadPath = 'staff';
    public $allowedExtensions = 'jpg,jpeg,png,gif';
    public $minSize = 0;
    public $maxSize = 5368709120;
    public $maxFiles = 1;
    public $perPage = 8;
    public $aliasModule = 'StaffModule.staff';
    public $pathBackend = '/staff/staffBackend/';

    public function getInstall()
    {
        if (parent::getInstall()) {
            @mkdir(Yii::app()->uploadManager->getBasePath() . DIRECTORY_SEPARATOR . $this->uploadPath, 0777);
        }

        return false;
    }

    public function checkSelf()
    {
        $messages = [];

        $uploadPath = Yii::app()->uploadManager->getBasePath() . DIRECTORY_SEPARATOR . $this->uploadPath;

        if (!is_writable($uploadPath)) {
            $messages[WebModule::CHECK_ERROR][] = [
                'type'    => WebModule::CHECK_ERROR,
                'message' => Yii::t(
                        $this->aliasModule,
                        'Directory "{dir}" is not accessible for write! {link}',
                        [
                            '{dir}'  => $uploadPath,
                            '{link}' => CHtml::link(
                                    Yii::t($this->aliasModule, 'Change settings'),
                                    [
                                        '/yupe/backend/modulesettings/',
                                        'module' => 'staff',
                                    ]
                                ),
                        ]
                    ),
            ];
        }

        return (isset($messages[WebModule::CHECK_ERROR])) ? $messages : true;
    }

    public function getParamsLabels()
    {
        return [
            'mainCategory'      => Yii::t($this->aliasModule, 'Main staff category'),
            'adminMenuOrder'    => Yii::t($this->aliasModule, 'Menu items order'),
            'editor'            => Yii::t($this->aliasModule, 'Visual Editor'),
            'uploadPath'        => Yii::t(
                    $this->aliasModule,
                    'Uploading files catalog (relatively {path})',
                    [
                        '{path}' => Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . Yii::app()->getModule(
                                "yupe"
                            )->uploadPath
                    ]
                ),
            'allowedExtensions' => Yii::t($this->aliasModule, 'Accepted extensions (separated by comma)'),
            'minSize'           => Yii::t($this->aliasModule, 'Minimum size (in bytes)'),
            'maxSize'           => Yii::t($this->aliasModule, 'Maximum size (in bytes)'),
            'perPage'           => Yii::t($this->aliasModule, 'Staff per page')
        ];
    }

    public function getEditableParams()
    {
        return [
            'adminMenuOrder',
            'editor'       => Yii::app()->getModule('yupe')->getEditors(),
            'mainCategory' => CHtml::listData($this->getCategoryList(), 'id', 'name'),
            'uploadPath',
            'allowedExtensions',
            'minSize',
            'maxSize',
            'perPage'
        ];
    }

    public function getEditableParamsGroups()
    {
        return [
            'main'   => [
                'label' => Yii::t($this->aliasModule, 'General module settings'),
                'items' => [
                    'adminMenuOrder',
                    'editor',
                    'mainCategory'
                ]
            ],
            'images' => [
                'label' => Yii::t($this->aliasModule, 'Images settings'),
                'items' => [
                    'uploadPath',
                    'allowedExtensions',
                    'minSize',
                    'maxSize'
                ]
            ],
            'list'   => [
                'label' => Yii::t($this->aliasModule, 'staff lists'),
                'items' => [
                    'perPage'
                ]
            ],
        ];
    }

    public function getVersion()
    {
        return self::VERSION;
    }

    public function getIsInstallDefault()
    {
        return true;
    }

    public function getCategory()
    {
        return Yii::t($this->aliasModule, 'Content');
    }

    public function getName()
    {
        return Yii::t($this->aliasModule, 'staff');
    }

    public function getDescription()
    {
        return Yii::t($this->aliasModule, 'Module for creating and management staff');
    }

    public function getAuthor()
    {
        return Yii::t($this->aliasModule, 'Sergey Latyshkov');
    }

    public function getAuthorEmail()
    {
        return Yii::t($this->aliasModule, 'sergey.e.latyshkov@yandex.ru');
    }

    public function getIcon()
    {
        return "fa fa-fw fa-user";
    }

    public function getAdminPageLink()
    {
        return $this->pathBackend. 'index';
    }

    public function getNavigation()
    {
        return [
            [
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t($this->aliasModule, 'staff list'),
                'url'   => [$this->pathBackend. 'index']
            ],
            [
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t($this->aliasModule, 'Create staff'),
                'url'   => [$this->pathBackend. 'create']
            ],
        ];
    }

    public function init()
    {
        parent::init();

        $this->setImport(
            [
                'staff.models.*'
            ]
        );
    }

    public function getAuthItems()
    {
        return [
            [
                'name'        => 'staff.staffManager',
                'description' => Yii::t($this->aliasModule, 'Manage staff'),
                'type'        => AuthItem::TYPE_TASK,
                'items'       => [
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'staff.staffBackend.Create',
                        'description' => Yii::t($this->aliasModule, 'Creating staff')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'staff.staffBackend.Delete',
                        'description' => Yii::t($this->aliasModule, 'Removing staff')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'staff.staffBackend.Index',
                        'description' => Yii::t($this->aliasModule, 'List of staff')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'staff.staffBackend.Update',
                        'description' => Yii::t($this->aliasModule, 'Editing staff')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'staff.staffBackend.Inline',
                        'description' => Yii::t($this->aliasModule, 'Editing staff')
                    ],
                    [
                        'type'        => AuthItem::TYPE_OPERATION,
                        'name'        => 'staff.staffBackend.View',
                        'description' => Yii::t($this->aliasModule, 'Viewing staff')
                    ],
                ]
            ]
        ];
    }
}
