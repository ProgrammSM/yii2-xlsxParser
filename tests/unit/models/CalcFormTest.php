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
     * Получение конфигурации из базы данных.
     */
    public function testGetConfiguration()
    {
        $calcForm = new CalcForm();
        $this->assertArraySubset([[1, 4.0], [2, 2.3], [3, 3.5]],
            $calcForm->getConfiguration());
    }

    /**
     * Проверка на допустимость загружаемого файла
     */
    public function testValidate()
    {
        /**
         * Эмулируем загрузку файла наполняя массив $_FILES
         */
        $path = Yii::getAlias('tests') . '/_data/parsingFile.xlsx';
        $size = filesize($path);
        $_FILES['file'] = [
            'name' => 'parsingFile.xlsx',
            'type' => mime_content_type($path),
            'tmp_name' => $path,
            'error' => 0,
            'size' => $size,
        ];

        $calcForm = new CalcForm();
        $calcForm->file = UploadedFile::getInstanceByName('file');
        $this->assertTrue($calcForm->validate());
    }

    /**
     * Проверка на недопустимость загружаемого файла
     */
    public function testInvalidValidate()
    {
        /**
         * Эмулируем загрузку файла наполняя массив $_FILES
         */
        $path = Yii::getAlias('tests') . '/_data/data.db';
        $size = filesize($path);
        $_FILES['file'] = [
            'name' => 'data.db',
            'type' => mime_content_type($path),
            'tmp_name' => $path,
            'error' => 0,
            'size' => $size,
        ];

        $calcForm = new CalcForm();
        $calcForm->file = UploadedFile::getInstanceByName('file');
        $this->assertFalse($calcForm->validate());
    }
}
