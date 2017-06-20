<?php
/**
 * Шаблон загрузки файлов для калькуляции
 */

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Вычислить';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-calc">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="container">
        <?php $form = ActiveForm::begin([
            'id' => 'input-form',
            'options' => ['enctype' => 'multipart/form-data']
        ]); ?>
        <div class="form-group">
            <p>Выберите файл для загрузки и нажмите "Отправить"</p>
            <input type="file" id="inpFile"/>
            <?= Html::submitButton('Отправить',
                ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
