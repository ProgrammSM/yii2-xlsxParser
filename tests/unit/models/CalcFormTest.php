<?php

namespace tests\models;

use app\models\CalcForm;

/**
 * Unit-test для CalcForm.
 *
 * @package tests\models
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
}
