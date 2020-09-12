<?php
use \yii\grid\GridView;
use \yii\widgets\ListView;
use \kop\y2sp\ScrollPager;
use \yii\widgets\Pjax;
?>

<H1>News feed</H1>
<?php foreach($categories as $category): ?>
    <?= $category->title ?>
<?php endforeach ?>

<?php //Pjax::begin(); ?>
<?php
    echo GridView::widget([
        'dataProvider' => $articlesDataProvider,
        'pager' => [
            'class' => ScrollPager::className(),
            'container' => '.grid-view tbody',
            'item' => 'tr',
            //'paginationSelector' => '.grid-view .pagination',
            'triggerText' => Yii::t('app', 'Show more'),
            'triggerTemplate' => '<tr class="ias-trigger"><td colspan="100%" style="text-align: center"><a style="cursor: pointer">{text}</a></td></tr>',
        ],
    ]);
//    echo ListView::widget([
//        'dataProvider' => $articlesDataProvider,
//        'itemOptions' => ['class' => 'item'],
//        'itemView' => '_item_view',
//        'pager' => ['class' => ScrollPager::className()]
//    ]);
?>
<?php //Pjax::end(); ?>
