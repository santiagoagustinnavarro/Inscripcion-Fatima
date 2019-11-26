<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\bootstrap\DropDown;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
   <style type="text/css">
   .navbar-inverse .dropdown-menu {
     background-color: #222;
     
     
}
.navbar-inverse .dropdown-menu a{
     color: #9d9d9d;
     
}

    
   </style>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '<div class=\'glyphicon glyphicon-home\'></div>',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
            
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => [
            ['label' => 'INSTITUCIÓN', 'url' => 'http://jazz.serverdnspoint.com/~colegiof/sitioweb/index.php/institucional'],
            ['label' => 'COLEGIO', 'url' => '',
                'items'=>[
                ['label' => 'Docentes', 'url' => 'http://jazz.serverdnspoint.com/~colegiof/sitioweb/index.php/colegio/docentes'],
                ['label' => 'Alumnos', 'url' => 'http://jazz.serverdnspoint.com/~colegiof/sitioweb/index.php/colegio/alumnos'],
                ['label' => 'Administración', 'url' => 'http://jazz.serverdnspoint.com/~colegiof/sitioweb/index.php/colegio/administracion']
                        ]
            ],
            ['label' => 'ACADÉMICO', 'url' => '','items'=>[
                ['label'=>'Niveles','items'=>[' <ul class="dropdown-menu">
                <li><a href="#">Steelers</a></li>
                <li><a href="#">Ravens</a></li>
                <li><a href="#">Browns</a></li>
                <li><a href="#">Bengals</a></li>
            </ul>']],
                ['label' => 'Áreas especiales', 'url' => 'http://jazz.serverdnspoint.com/~colegiof/sitioweb/index.php/colegio/alumnos'],
                
                
            
            ]],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
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
