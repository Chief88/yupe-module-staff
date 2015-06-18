<?php
$this->breadcrumbs = [
    Yii::t($this->aliasModule, 'Staff') => [$this->patchBackend .'index'],
    Yii::t($this->aliasModule, 'Create'),
];

$this->pageTitle = Yii::t($this->aliasModule, 'Staff - create');

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
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t($this->aliasModule, 'Staff'); ?>
        <small><?php echo Yii::t($this->aliasModule, 'create'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', [
    'model' => $model,
    'aliasModule' => $this->aliasModule
]); ?>
