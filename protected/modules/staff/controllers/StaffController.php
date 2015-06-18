<?php

/**
 * StaffController контроллер для работы с сотрудниками в публичной части сайта
 *
 * @author Chief88 <serg.latyshkov@gmail.com>
 * @since 0.9.6
 *
 */
class StaffController extends yupe\components\controllers\FrontController
{

    public function actionIndex()
    {
        $this->processPageRequest('page');

        $criteria = new CDbCriteria();
        $criteria->order = 't.sort';

        $dataProvider = new CActiveDataProvider('Staff', [
            'criteria' => $criteria,
            'pagination'=>[
                'pageSize'=>$this->module->perPage,
                'pageVar' =>'page',
            ],
        ]);

        if (Yii::app()->request->isAjaxRequest){
            $this->renderPartial('_loopAjax', [
                'dataProvider'=>$dataProvider,
            ]);
            Yii::app()->end();
        } else {
            $categoryModel = \Category::model()->findByAttributes( ['slug' => 'stranica-nasha-komanda']);

            $this->render('index', [
                'dataProvider'=>$dataProvider,
                'categoryModel'=>$categoryModel,
            ]);
        }
    }

    protected function processPageRequest($param='page')
    {
        if (Yii::app()->request->isAjaxRequest && isset($_POST[$param]))
            $_GET[$param] = Yii::app()->request->getPost($param);
    }
}
