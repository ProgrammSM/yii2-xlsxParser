<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Вычислить';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="container">
        <?php $form = ActiveForm::begin(['id' => 'input-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'file')->fileInput(); ?>
        <div class="form-group">
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
</div>
