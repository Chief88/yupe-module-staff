<?php if (!empty($categoryModel)) {

    $this->pageTitle = !empty($categoryModel->page_title) ? $categoryModel->page_title : $this->pageTitle;
    $this->metaDescription = !empty($categoryModel->seo_description) ? $categoryModel->seo_description : $this->metaDescription;
    $this->metaKeywords = !empty($categoryModel->seo_keywords) ? $categoryModel->seo_keywords : $this->metaKeywords;
    $this->metaNoIndex = $categoryModel->no_index == 1 ? true : false;
    $mainAssets = Yii::app()->getTheme()->getAssetsUrl();

} ?>

<div class="container">
    <nav>
        <ul itemtype="https://data-vocabulary.org/Breadcrumb" itemscope="" class="breadcrumb">
            <li><a itemprop="url" href="/"><span itemprop="title">Главная</span></a>
            <li><span itemprop="title">Клуб</span>
            <li><span itemprop="title">Команда</span>
        </ul>
    </nav>
    <h1>Команда</h1>

    <ul class="team-list">
        <?php $this->renderPartial('_loopAjax', ['dataProvider' => $dataProvider]); ?>
    </ul>

    <?php if ((int)$dataProvider->pagination->pageCount > (int)Yii::app()->request->getParam('page', 1)):{ ?>

        <p id="loading" style="display:none"><img src="<?= $mainAssets; ?>/images/ajax-loader.gif" alt="" /></p>
        <div class="load-content warning-line-1">
            <a id="showMore" href="#" class="btn btn-primary">Еще сотрудники</a>
        </div>

    <?php }endif; ?>

</div>