<?php

/**
 * StaffBackendController контроллер для работы с сотрудниками в панели управления
 *
 * @author    Chief88 <serg.latyshkov@gmail.com>
 * @version   0.9.6
 *
 */
class StaffBackendController extends yupe\components\controllers\BackController
{
    public $aliasModule = 'StaffModule.staff';
    public $patchBackend = '/staff/staffBackend/';

    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin']],
            ['allow', 'actions' => ['create'], 'roles' => ['staff.staffBackend.Create']],
            ['allow', 'actions' => ['delete'], 'roles' => ['staff.staffBackend.Delete']],
            ['allow', 'actions' => ['index'], 'roles' => ['staff.staffBackend.Index']],
            ['allow', 'actions' => ['inline'], 'roles' => ['staff.staffBackend.Update']],
            ['allow', 'actions' => ['update', 'toggle', 'inline', 'sortable'], 'roles' => ['staff.staffBackend.Update']],
            ['allow', 'actions' => ['view'], 'roles' => ['staff.staffBackend.View']],
            ['deny']
        ];
    }

    public function actions()
    {
        return [
            'inline' => [
                'class'           => 'yupe\components\actions\YInLineEditAction',
                'model'           => 'Staff',
                'validAttributes' => ['first_name', 'last_name', 'patronymic']
            ],
            'toggle' => [
                'class'     => 'booster.actions.TbToggleAction',
                'modelName' => 'Staff',
            ],
            'sortable' => [
                'class' => 'yupe\components\actions\SortAction',
                'model' => 'Staff',
                'attribute' => 'sort'
            ]
        ];
    }

    /**
     * Displays a particular model.
     *
     * @param integer $id the ID of the model to be displayed
     *
     * @return void
     */
    public function actionView($id)
    {
        $this->render('view', ['model' => $this->loadModel($id)]);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return void
     */
    public function actionCreate()
    {
        $model = new Staff();

        if (($data = Yii::app()->getRequest()->getPost('Staff')) !== null) {

            $model->setAttributes($data);

            if ($model->save()) {

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t($this->aliasModule, 'Worker was created!')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        ['create']
                    )
                );
            }
        }

        $this->render('create', ['model' => $model]);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param null $alias
     * @param integer $id the ID of the model to be updated
     *
     * @throws CHttpException
     *
     * @return void
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (($data = Yii::app()->getRequest()->getPost('Staff')) !== null) {

            $model->setAttributes($data);

            if ($model->save()) {

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t($this->aliasModule, 'Worker was updated!')
                );

                $this->redirect(
                    Yii::app()->getRequest()->getIsPostRequest()
                        ? (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        ['update', 'id' => $model->id]
                    )
                        : ['view', 'id' => $model->id]
                );
            }
        }

        $this->render('update', [
                'model'      => $model,
            ]
        );
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param null $alias
     * @param integer $id the ID of the model to be deleted
     *
     * @throws CHttpException
     *
     * @return void
     */
    public function actionDelete($id = null)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {

            $this->loadModel($id)->delete();

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t($this->aliasModule, 'Record was removed!')
            );

            // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
            Yii::app()->getRequest()->getParam('ajax') !== null || $this->redirect(
                (array)Yii::app()->getRequest()->getPost('returnUrl', 'index')
            );
        } else {
            throw new CHttpException(
                400,
                Yii::t($this->aliasModule, 'Bad raquest. Please don\'t use similar requests anymore!')
            );
        }
    }

    /**
     * Manages all models.
     *
     * @return void
     */
    public function actionIndex()
    {
        $model = new Staff('search');

        $model->unsetAttributes(); // clear any default values

        $model->setAttributes(
            Yii::app()->getRequest()->getParam(
                'Staff',
                []
            )
        );
        $this->render('index', ['model' => $model]);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     *
     * @param integer the ID of the model to be loaded
     *
     * @return void
     *
     * @throws CHttpException If record not found
     */
    public function loadModel($id)
    {
        if (($model = Staff::model()->findByPk($id)) === null) {
            throw new CHttpException(
                404,
                Yii::t($this->aliasModule, 'Requested page was not found!')
            );
        }

        return $model;
    }
}
