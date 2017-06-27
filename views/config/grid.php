<?php
/**
 * Шаблон с конфигурацией веб-приложения
 */

use yii\helpers\Html;

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
$javascript = <<<JS
/**
* Добавление новой строки
*/
$("#srvAdd").on("click", function() {
    // Проверяем наличие уже созданной "новой услуги"
    if ($("[data-id=0]").length == 0) {
        // Добавляем в таблицу новую строку
        $("#service-tab").append(
            '<tr style="border: 1px solid red">' + 
                '<td class="text-center">' + 
                    '<input type="checkbox" class="check-id" data-id="0" disabled="disabled"/>' +
                '</td>' +
                '<td class="text-center editable">0</td>' +
                '<td class="text-center editable">0.0</td>' +
            '</tr>'
         );
        // Заменяем кнопку на "Сохранить..."
        $("#srvAdd").html("Сохранить новую услугу").attr("id", "saveSrv");
        $("#saveSrv").on('click', function() {
            var td = $("[data-id=0]").parent().parent().children("td");
            var type = $(td[1]).html();
            var coef = $(td[2]).html();
            // Формируем запрос с данными новой услуги
            var data = '{' +
                '"type":"' + type + 
                '","coef":"' + coef + 
            '"}';
            // Переходим по сформированной строке
            location.href = "index.php?r=config/new&service=" + data;
        });
    }
});

/**
* Удаление строки
*/
$("#strRemove").on("click", function() {
    var dataTest = {};
    // Формируем json строку содержащий id строки в базе данных
    var i = 0;
    var checkbox = $(".check-id:checked");
    var data = "{";
    if (checkbox.length > 0) {
        checkbox.each(function() {
            if (i > 0) data += ",";
            data += '"' + i + '":' + $(this).attr('data-id');
            dataTest[String(i++)] = $(this).attr('data-id');
        });
    }
    data += "}";
    location.href = "index.php?r=config/remove&id=" + data;    
});

/**
* Редактирование услуги
* 
* Вешаем слушатель кликов по td с классом editable
*/
$(document).on("click", ".editable", function(e)	{
	var t = e.target || e.srcElement;
	var elm_name = t.tagName.toLowerCase();
	// Если это инпут, то ничего не делаем
	if(elm_name == "input")	{
	    return false;
	}
	// Извлекаем содержимое из td, вставляем его вместе с input обратно в td
	var val = $(this).html();
	var input = '<input type="text" id="edit" value="'+val+'" />';
	$(this).empty().append(input);
	// Вешаем слушатель на потерю фокуса input
	$('#edit').focus().blur(function()	{
	    // Извлекаем значение input
		var val = $(this).val();
		// Получаем список дочерних элементов строки с услугой
		var service = $(this).parent().parent().children("td");
		// Присваиваем значение input внутрь td, где он находился
		$(this).parent().empty().html(val);
		// Извлекаем значения всех полей услуги
		var id = $($(service).children()[0]).attr('data-id');
		var type = $(service[1]).html();
		var coef = $(service[2]).html();
        // Формируем json строку
        if (id != 0) {        
            var data = '{' +
                '"id":"' + id + 
                '","type":"' + type + 
                '","coef":"' + coef + 
            '"}';
            // Переходим по сформированной строке
            location.href = "index.php?r=config/edit&service=" + data;
        }

    });
});

/**
* Потеря фокуса при нажатии Enter
*/
$(window).keydown(function(event){
	if(event.keyCode == 13) {	//13 - enter
		$('#edit').blur();
	}
});

/**
* Восстановление настроек по умолчанию
*/
$("#restore").on("click", function() {
    location.href = "index.php?r=config/restore";
});
JS;
$this->registerJs($javascript, yii\web\View::POS_READY);
?>
<div class="config-grid">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="container" style="margin-top: 50px">
        <table id="service-tab" border="1" class="text-left" style="width: 500px">
            <tr>
                <th class="text-center"></th>
                <th class="text-center">Тип</th>
                <th class="text-center">Коэффициент</th>
            </tr>
            <?php foreach ($config as $service) { ?>
                <tr>
                    <td class="text-center">
                        <input type="checkbox" class="check-id"
                               data-id="<?= $service['id'] ?>"/>
                    </td>
                    <td class="text-center editable"><?= $service['type'] ?></td>
                    <td class="text-center editable"><?= $service['coef'] ?></td>
                </tr>
            <?php } ?>
        </table>
        <br/>
        <?= Html::Button('Добавить строку',
            ['class' => 'btn btn-primary', 'id' => 'srvAdd']) ?>
        <?= Html::Button('Удалить выделенное',
            ['class' => 'btn btn-primary', 'id' => 'strRemove']) ?>
        <br/>
        <br/>
        <?= Html::Button('Восстановить настройки по умолчанию',
            ['class' => 'btn btn-primary', 'id' => 'restore']) ?>
    </div>
</div>
