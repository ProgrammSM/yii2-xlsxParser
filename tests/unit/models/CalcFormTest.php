<?php

namespace tests\models;

use app\models\CalcForm;
use Yii;
use yii\web\UploadedFile;

/**
 * Unit-test для CalcForm.
 */
class CalcFormTest extends \Codeception\Test\Unit
{
    /**
     * Эмулирование загрузки указанного файла через $_FILES
     *
     * @param string $file имя файла находящегося в @tests/_data/
     */
    private function emuDownloadFile($file)
    {
        $path = Yii::getAlias('tests') . '/_data/' . $file;
        $size = filesize($path);
        $_FILES['file'] = [
            'name' => $file,
            'type' => mime_content_type($path),
            'tmp_name' => $path,
            'error' => 0,
            'size' => $size,
        ];
    }

    /**
     * Получение конфигурации из базы данных.
     */
    public function testGetConfiguration()
    {
        $calcForm = new CalcForm();
        $this->assertArraySubset([
            ['type' => 1, 'coef' => 4.0],
            ['type' => 2, 'coef' => 2.3],
            ['type' => 3, 'coef' => 3.5]
        ],
            $calcForm->getConfiguration());
    }

    /**
     * Проверка на допустимость загружаемого файла
     */
    public function testValidate()
    {
        $this->emuDownloadFile('parsingFile.xlsx');

        $calcForm = new CalcForm();
        $calcForm->file = UploadedFile::getInstanceByName('file');
        $this->assertTrue($calcForm->validate());
    }

    /**
     * Проверка на недопустимость загружаемого файла
     */
    public function testInvalidValidate()
    {
        $this->emuDownloadFile('data.db');

        $calcForm = new CalcForm();
        $calcForm->file = UploadedFile::getInstanceByName('file');
        $this->assertFalse($calcForm->validate());
    }

    /**
     * Проверка на получение сформированных данных для представления
     */
    public function testGetData()
    {
        $this->emuDownloadFile('parsingFile.xlsx');

        $calcForm = new CalcForm();
        $calcForm->file = UploadedFile::getInstanceByName('file');
        $this->assertArraySubset([
            ["Ремонт отмостки", 35000.0],
            ["Ремонт фасада", 122500.0],
            ["Замена лампочки", 2300.0],
            ["Замена стояков ХГВС", 60000.0]
        ], $calcForm->getData([
            ['type' => 1, 'coef' => 4.0],
            ['type' => 2, 'coef' => 2.3],
            ['type' => 3, 'coef' => 3.5],
        ], 500.0));
    }
}
