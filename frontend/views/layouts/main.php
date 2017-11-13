<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\LanguageWidget;
use common\widgets\Alert;
use frontend\widgets\ProfileWidget;
use pjhl\multilanguage\assets\ChangeLanguageAsset;
use frontend\widgets\ModalWidget;
AppAsset::register($this);
ChangeLanguageAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?= (Yii::$app->user->isGuest ? ModalWidget::widget([]) : ''); ?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => Yii::t('app', 'Home'), 'url' => ['/site/index']],
        ['label' => Yii::t('app', 'About'), 'url' => ['/site/about']],
        ['label' => Yii::t('app', 'Contact'), 'url' => ['/site/contact']],
    ];
	//if(Yii::$app->user->can('customer')){
		$menuItems[] = ['label' => Yii::t('app', 'Orders'), 'url' => ['/orders/index']];
		$menuItems[] = ['label' => Yii::t('app', 'Performers'), 'url' => ['/performers/index']];
	//}
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => Yii::t('app', 'Signup'), 'url' => ['/site/signup']];
        $menuItems[] = ['label' => Yii::t('app', 'Login'), 'url' => '#', 'options' => ['data-toggle' => 'modal', 'data-target' => '#login-modal']];
    } else {
        $menuItems[] = ProfileWidget::widget();
    }
	echo LanguageWidget::widget();
	/*echo '<a href="#" class="multilanguage-set" data-language="1">EN</a>
<a href="#" class="multilanguage-set" data-language="2">RU</a>
<a href="#" class="multilanguage-set" data-language="3">UA</a>';*/
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
