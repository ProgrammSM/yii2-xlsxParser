<?php
/**
 * Шаблон с конфигурацией веб-приложения
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="config-grid">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="container" style="margin-top: 50px">
        <?php $form = ActiveForm::begin([
            'id' => 'config-form',
            'method' => 'post'
        ]); ?>
        <table border="1" class="text-left" style="width: 500px">
            <tr>
                <th class="text-center"></th>
                <th class="text-center">Тип</th>
                <th class="text-center">Коэффициент</th>
            </tr>
            <tr>
                <td class="text-center">
                    <input type="checkbox" data-id="1"/>
                </td>
                <td class="text-center">1</td>
                <td class="text-center">4.0</td>
            </tr>
            <tr>
                <td class="text-center">
                    <input type="checkbox" data-id="2"/>
                </td>
                <td class="text-center">2</td>
                <td class="text-center">2.3</td>
            </tr>
            <tr>
                <td class="text-center">
                    <input type="checkbox" data-id="3"/>
                </td>
                <td class="text-center">3</td>
                <td class="text-center">3.5</td>
            </tr>
        </table>
        <br/>
        <?= Html::Button('Добавить строку',
            ['class' => 'btn btn-primary']) ?>
        <?= Html::Button('Удалить выделенное',
            ['class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
