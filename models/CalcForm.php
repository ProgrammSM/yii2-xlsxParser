<?php

namespace app\models;

use yii\base\Model;
use \yii\web\UploadedFile;

/**
 * Модель вычисления.
 *
 * Class ClacForm
 */
class CalcForm extends Model
{
    /**
     * @var array[] Массив сформированных данных, полученных из файла xlsx и
     *      обработанный компонентом xlsxParser.
     */
    public $data;

    /**
     * @var UploadedFile Загружаемый файл.
     */
    public $file;

    /**
     * Получаем конфигурацию для калькуляции и формирования из базы данных
     * SQLite.
     *
     * @return array[]
     */
    public function getConfiguration()
    {
        // Делаем SQL-запрос в таблицу services
        $services = Services::find()->asArray()->all();
        $result = [];
        foreach ($services as $srv) {
            $result[] = [$srv['type'], $srv['coef']];
        }

        return $result;
    }
}
