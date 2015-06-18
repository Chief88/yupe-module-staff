<?php $models = $dataProvider->getData(); ?>
<?php foreach($models as $model):{ ?>

    <?php $this->renderPartial('_itemStaff', ['data' => $model]); ?>

<?php }endforeach; ?>

<?php if ((int)$dataProvider->pagination->pageCount > (int)Yii::app()->request->getParam('page', 1)):{ ?>

    <script type="text/javascript">
        /*<![CDATA[*/
        jQuery(document).ready(function(){

            $('.paginator').hide();

            // запоминаем текущую страницу и их максимальное количество
            var page = parseInt('<?php echo (int)Yii::app()->request->getParam('page', 1); ?>');
            var pageCount = parseInt('<?php echo (int)$dataProvider->pagination->pageCount; ?>');

            var loadingFlag = false;

            $('#showMore').one('click', function(e){
                e.preventDefault();
                // защита от повторных нажатий
                if (!loadingFlag)
                {
                    // выставляем блокировку
                    loadingFlag = true;

                    // отображаем анимацию загрузки
                    $('#loading').show();

                    $.ajax({
                        type: 'post',
                        url: window.location.href,
                        data: {
                            // передаём номер нужной страницы методом POST
                            'page': page + 1,
                            '<?php echo Yii::app()->request->csrfTokenName; ?>': '<?php echo Yii::app()->request->csrfToken; ?>'
                        },
                        success: function(data)
                        {
                            // увеличиваем номер текущей страницы и снимаем блокировку
                            page++;
                            loadingFlag = false;

                            // прячем анимацию загрузки
                            $('#loading').hide();

                            // вставляем полученные записи после имеющихся в наш блок
                            $('ul.team-list').append(data);

                            // если достигли максимальной страницы, то прячем кнопку
                            if (page >= pageCount)
                                $('.warning-line-1').hide();
                        }
                    });
                }
                return false;
            });
        });
    </script>

<?php }endif; ?>