<?php

/** @var yii\web\View $this */

/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\AuthForm $model */

use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = 'Register';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('_auth-form', ['model' => $model]) ?>

<div class="mt-3">
    <p>Have account? <?= Html::a('Login', Url::toRoute('/site/login')) ?></p>
</div>
