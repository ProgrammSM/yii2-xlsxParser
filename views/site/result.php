<?php
/**
 * Страница с таблицей стоимости работ
 */
use yii\helpers\Html;

$this->title = "Стоимость работ";
$data = $model->data;
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="container text-center" style="margin-top: 50px;">
    <table border="1" class="text-left" style="width: 500px">
        <tr>
            <th class="text-center">Название услуги</th>
            <th class="text-center">Стоимость</th>
        </tr>
        <?php
        foreach ($data as list ($name, $value)) {
            echo "<tr><td>$name</td><td>$value</td></tr>";
        }
        ?>
    </table>
</div>
