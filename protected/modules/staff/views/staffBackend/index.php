<?php

/**
 * @var $model staff
 * @var $this StaffBackendController
 */

$this->breadcrumbs = [
    Yii::t($this->aliasModule, 'Staff') => [$this->patchBackend .'index'],
    Yii::t($this->aliasModule, 'Management'),
];

$this->pageTitle = Yii::t($this->aliasModule, 'staff - management');

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
]; ?>

<div class="page-header">
    <h1>
        <?php echo Yii::t($this->aliasModule, 'Staff'); ?>
        <small><?php echo Yii::t($this->aliasModule, 'management'); ?></small>
    </h1>
</div>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id'                => 'staff-grid',
        'sortableRows'      => true,
        'sortableAjaxSave'  => true,
        'sortableAttribute' => 'sort',
        'sortableAction'    => $this->patchBackend .'sortable',
        'dataProvider'      => $model->search(),
        'filter'            => $model,
        'columns'           => [
            [
                'name'        => 'id',
                'htmlOptions' => ['style' => 'width:20px'],
                'type'        => 'raw',
                'value'       => 'CHtml::link($data->id, array("/staff/staffBackend/update", "id" => $data->id))'
            ],
            [
                'header' => Yii::t($this->aliasModule, 'Image'),
                'value'  => 'CHtml::image($data->getImageUrl(100, 100), $data->first_name)',
                'type'   => 'raw'
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'first_name',
                'editable' => [
                    'url'    => $this->createUrl($this->patchBackend .'inline'),
                    'mode'   => 'inline',
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'filter'   => CHtml::activeTextField($model, 'first_name', ['class' => 'form-control']),
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'last_name',
                'editable' => [
                    'url'    => $this->createUrl($this->patchBackend .'inline'),
                    'mode'   => 'inline',
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'filter'   => CHtml::activeTextField($model, 'last_name', ['class' => 'form-control']),
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'patronymic',
                'editable' => [
                    'url'    => $this->createUrl($this->patchBackend .'inline'),
                    'mode'   => 'inline',
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'filter'   => CHtml::activeTextField($model, 'patronymic', ['class' => 'form-control']),
            ],
            [
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'template'    => '{update}{delete}',
            ],
        ],
    ]
); ?>
