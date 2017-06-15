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
    public $xlsx;

    /**
     * Инициализация переменных
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
     * @param string $pathToXlsx         Путь из временной директории до файла
     * @param array  $arrayConfiguration Конфигурация по формированию из базы
     *                                   данных
     * @param float  $rate               Базовая ставка стоимости работ за час
     *
     * @return array
     */
    public function parsingFile(
        string $pathToXlsx,
        array $arrayConfiguration,
        float $rate
    ) {
        $this->xlsx = PHPExcel_IOFactory::load($pathToXlsx);

        $sheet = $this->xlsx->getSheet(0);
        $rowMax = $sheet->getHighestRow();
        $arrayXlsx = [];
        for ($i = 0; $i < $rowMax; $i++) {
            $serviceName = $this->getCellValue($i, 0);
            $manHour = $this->getCellValue($i, 1);
            $serviceType = $this->getCellValue($i, 2);

            if ($serviceName == null || $manHour == null
                || $serviceType == null
            ) {
                continue;
            }
            $arrayXlsx[] = [$serviceName, $manHour, $serviceType];
        }

        $arrayResult = [];
        foreach ($arrayXlsx as list($serviceName, $manHour, $serviceType)) {
            foreach ($arrayConfiguration as list($confServiceType, $confCoef)) {
                if ($serviceType == $confServiceType) {
                    $value = $manHour * $confCoef * $rate;

                    $arrayResult[] = [$serviceName, $value];
                    continue;
                }
            }
        }

        return $arrayResult;
    }

    /**
     * Получение дынных я выбранной ячейки
     *
     * @param $row
     * @param $col
     *
     * @return null
     */
    private function getCellValue($row, $col)
    {
        $row++;
        if (is_object($this->xlsx)) {
            $sheet = $this->xlsx->getSheet(0);
            if ($sheet->cellExistsByColumnAndRow($col, $row)) {
                $cellVal = $sheet->getCellByColumnAndRow($col, $row);
                return $cellVal->getValue();
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
}
