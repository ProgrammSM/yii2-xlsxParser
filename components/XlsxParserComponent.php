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
     * @param mixed[] $config Конфигурация по формированию из
     *                        базы данных
     * @param float   $rate   Базовая ставка стоимости работ за час
     *
     * @return array[]    Возвращается массив содержащий массивы с названиями
     *                  работ и посчитанной стоимостью
     */
    public function parse($path, $config, $rate)
    {
        $this->xlsx = PHPExcel_IOFactory::load($path);

        $sheet = $this->xlsx->getSheet(0);
        $rowMax = $sheet->getHighestRow();
        $data = [];
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
        foreach ($data as list($serviceName, $manHour, $serviceType)) {
            foreach ($config as list($confServiceType, $confCoef)) {
                if ($serviceType == $confServiceType) {
                    $value = $manHour * $confCoef * $rate;

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
