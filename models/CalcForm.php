<?php

namespace app\models;

use Yii;
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
     * @var UploadedFile $file Загружаемый файл. Необходимо для приёма файла
     *      через UploadedFile::getInstance() в SiteController, где требуется
     *      указать модель.
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
        // Делаем SQL-запрос в таблицу service
        $service = Service::find()->asArray()->all();
        $result = [];
        foreach ($service as $srv) {
            $result[] = ['type' => $srv['type'], 'coef' => $srv['coef']];
        }
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'], 'required', 'message' => 'Требуется выбрать файл'],
            [
                ['file'],
                'file',
                'extensions' => 'xlsx',
                'checkExtensionByMimeType' => false,
            ],
        ];
    }

    /**
     * Формируем данные с помощью компонента xlsxParser
     *
     * @param float $rate базовая зарплатная ставка за один час
     */
    public function getData($rate)
    {
        return Yii::$app->xlsxParser->parse($this->file->tempName, $this->getConfiguration(),
            $rate);
    }
}
