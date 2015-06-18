<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'id'                     => 'staff-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => ['class' => 'well', 'enctype' => 'multipart/form-data'],
    ]
); ?>
<div class="alert alert-info">
    <?php echo Yii::t($aliasModule, 'Fields with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t($aliasModule, 'are required'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-md-4">
        <?php echo $form->textFieldGroup($model, 'first_name'); ?>
        <?php echo $form->textFieldGroup($model, 'last_name'); ?>
        <?php echo $form->textFieldGroup($model, 'patronymic'); ?>
    </div>

    <div class="col-md-3">
        <?php $styleImage = !$model->isNewRecord && $model->image ? '' : ' display:none;' ?>
        <?= CHtml::image(
            !$model->isNewRecord && $model->image ? $model->getImageUrl() : '#',
            $model->first_name,
            [
                'class' => 'preview-image',
                'style' => 'max-width: 100%;'. $styleImage,
            ]
        ); ?>

        <?php if (!$model->isNewRecord && $model->image): ?>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="delete-file"> <?= Yii::t('YupeModule.yupe', 'Delete the file') ?>
                </label>
            </div>
        <?php endif; ?>

        <?= $form->fileFieldGroup($model, 'image', [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'onchange' => 'readURL(this);',
                        'style'    => 'background-color: inherit;'
                    ]
                ]
            ]
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 <?php echo $model->hasErrors('data') ? 'has-error' : ''; ?>">
        <?php echo $form->labelEx($model, 'data'); ?>
        <?php $this->widget(
            $this->module->getVisualEditor(),
            [
                'model'     => $model,
                'attribute' => 'data',
            ]
        ); ?>
        <?php echo $form->error($model, 'data'); ?>
    </div>
</div>

<br/>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => $model->isNewRecord ? Yii::t($aliasModule, 'Add worker and continue') : Yii::t(
                $aliasModule,
                'Save worker and continue'
            ),
    ]
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType'  => 'submit',
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label'       => $model->isNewRecord ? Yii::t($aliasModule, 'Add worker and close') : Yii::t(
                $aliasModule,
                'Save worker and close'
            ),
    ]
); ?>

<?php $this->endWidget(); ?>
