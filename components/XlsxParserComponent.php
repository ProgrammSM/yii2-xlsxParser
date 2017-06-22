<?php

namespace app\components;

use PHPExcel;
use PHPExcel_IOFactory;

/**
 * Парсер xlsx файлов
 *
 * @package app\components
 */
class XlsxParserComponent extends \yii\base\Component
{
    /**
     * @var PHPExcel Переменная в который загружается переданный документ
     */
    private $xlsx;

    /**
     * Инициализация xlsx для дальнейшей работы
     */
    public function init()
    {
        parent::init();
        $this->xlsx = new PHPExcel();
    }

    /**
     * Парсинг файла и формирование конечного результата с заданными
     * параметрами
     *
     * @param string  $path   Путь из временной директории до
     *                        файла
     * @param array[] $configData Конфигурация по формированию из
     *                        базы данных
     * @param float   $rate   Базовая ставка стоимости работ за час
     *
     * @return array[]    Возвращается массив содержащий массивы с названиями
     *                  работ и посчитанной стоимостью
     */
    public function parse($path, $configData, $rate)
    {
        /**
         * Загружаем указанный xlsx файл
         */
        $this->xlsx = PHPExcel_IOFactory::load($path);

        // Получаем первый лист
        $sheet = $this->xlsx->getSheet(0);
        // Выясняем максимальную строку
        $rowMax = $sheet->getHighestRow();
        $data = [];
        // Парсим таблицу заполняя массив
        for ($i = 0; $i < $rowMax; $i++) {
            $serviceName = $this->getCellValue($i, 0);
            $manHour = $this->getCellValue($i, 1);
            $serviceType = $this->getCellValue($i, 2);

            if ($serviceName == null || $manHour == null
                || $serviceType == null
            ) {
                continue;
            }
            $data[] = [$serviceName, $manHour, $serviceType];
        }

        $result = [];
        /**
         * Составляем массив данных применяя полученную конфигурацию
         */
        foreach ($data as list($serviceName, $manHour, $serviceType)) {
            foreach ($configData as $conf) {
                if ($serviceType == $conf['type']) {
                    $value = $manHour * $conf['coef'] * $rate;
                    $result[] = [$serviceName, $value];
                    continue;
                }
            }
        }
        return $result;
    }

    /**
     * Получение данных с указанной ячейки по номеру строки и номеру колонки
     *
     * @param int $row Номер строки
     * @param int $col Номер колонки
     *
     * @return mixed|null Возвращается значение ячейки, если указанная ячейка
     *                    существует
     */
    private function getCellValue($row, $col)
    {
        $row++;
        $sheet = $this->xlsx->getSheet(0);
        if ($sheet->cellExistsByColumnAndRow($col, $row)) {
            $cellVal = $sheet->getCellByColumnAndRow($col, $row);
            return $cellVal->getValue();
        } else {
            return null;
        }
    }
}
