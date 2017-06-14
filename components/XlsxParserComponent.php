<?php
namespace app\components;

use PHPExcel;
use PHPExcel_IOFactory;

class XlsxParserComponent extends \yii\base\Component
{
    public $xlsx;
    public $errorMsg;
    public $status;

    /**
     * Инициализация переменных
     */

    public function init()
    {
        parent::init();
        $this->errorMsg = "none";
        $this->xlsx = new PHPExcel();
        $this->status = false;
    }
//    function __construct()
//    {
//        $this->errorMsg = "none";
//        $this->xlsx = new PHPExcel();
//        $this->status = false;
//    }

    /**
     * @param $pathToXlsx
     * @param array $arrayConfiguration
     * @return array
     */

    public function parsingFile ($pathToXlsx, array $arrayConfiguration)
    {
        $this->xlsx = PHPExcel_IOFactory::load($pathToXlsx);

        $sheet = $this->xlsx->getSheet(0);

        $rowMax = $sheet->getHighestRow();
        $arrayXlsx = [];
        for ($i = 0; $i < $rowMax; $i++)
        {
            $serviceName = $this->getCellValue($i, 0);
            $manHour = $this->getCellValue($i, 1);
            $serviceType = $this->getCellValue($i, 2);

            if ($serviceName == null || $manHour == null || $serviceType == null)
                continue;
            $arrayXlsx[] = [$serviceName, $manHour, $serviceType];
        }

        $arrayResult = [];
        foreach ($arrayXlsx as $xlsRow)
        {
            foreach ($arrayConfiguration as $conf)
            {
                if ($xlsRow[2] == $conf[0])
                {
                    $rate = 500;
                    $value = $xlsRow[1] * $conf[1] * $rate;

                    $arrayResult[] = [$xlsRow[0], $value];
                    continue;
                }
            }
        }

        return $arrayResult;
    }

    /**
     * Получение значения указанной ячейки, начиная с 0
     * @param $s - лист
     * @param $r - строка
     * @param $c - ячейка
     * @return mixed|null
     */

    private function getCellValue ($row, $col)
    {
        $row++;
        if (is_object($this->xlsx))
        {
            $sheet = $this->xlsx->getSheet(0);
            if ($sheet->cellExistsByColumnAndRow($col, $row))
            {
                $cellVal = $sheet->getCellByColumnAndRow($col, $row);
                $this->status = true;
                return $cellVal->getValue();
            } else {

            }

        } else {
            $this->setErrorNotOpenFile();
            return null;
        }
    }

}
