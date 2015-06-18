<?php
$this->breadcrumbs = [
    Yii::t($this->aliasModule, 'Staff') => [$this->patchBackend .'index'],
    $model->first_name. ' '. $model->patronymic .' '. $model->last_name,
    Yii::t($this->aliasModule, 'Edit'),
];

$this->pageTitle = Yii::t($this->aliasModule, 'Staff - edit');

$this->menu = [
    [
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t($this->aliasModule, 'Staff list'),
        'url'   => [$this->patchBackend .'index']
    ],
    [
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t($this->aliasModule, 'Add'),
        'url'   => [$this->patchBackend .'create']
    ],
    ['label' => Yii::t($this->aliasModule, 'Worker') . ' «' .
        mb_substr($model->first_name. ' '. $model->patronymic .' '. $model->last_name, 0, 32) . '»'],
    [
        'icon'  => 'fa fa-fw fa-pencil',
        'label' => Yii::t($this->aliasModule, 'Edit worker'),
        'url'   => [
            $this->patchBackend .'update/',
            'id' => $model->id
        ]
    ],
    [
        'icon'        => 'fa fa-fw fa-trash-o',
        'label'       => Yii::t($this->aliasModule, 'Remove worker'),
        'url'         => '#',
        'linkOptions' => [
            'submit'  => [$this->patchBackend .'delete', 'id' => $model->id],
            'params'  => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t($this->aliasModule, 'Do you really want to remove the worker?'),
            'csrf'    => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t($this->aliasModule, 'Edit worker'); ?><br/>
        <small>&laquo;<?= $model->first_name. ' '. $model->patronymic .' '. $model->last_name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', [
    'model' => $model,
    'aliasModule' => $this->aliasModule
]); ?>
