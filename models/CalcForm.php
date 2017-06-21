<?php

namespace app\models;

use yii\base\Model;
use \yii\web\UploadedFile;

/**
 * Модель вычисления.
 *
 * Class CalcForm
 */
class CalcForm extends Model
{
    /**
     * @var UploadedFile $file1 Загружаемый файл. Необходимо для приёма файла через
     *      UploadedFile::getInstance() в SiteController, где требуется указать
     *      модель.
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

    /**
     * Правила проверки указанного файла
     *
     * @return array
     */
    public function rules()
    {
        return [
            [
                ['file'],
                'file',
                'extensions' => 'xlsx',
                'checkExtensionByMimeType' => false,
                'skipOnEmpty' => false,
            ],
        ];
    }
}
