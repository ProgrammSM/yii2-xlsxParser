<?php

namespace tests\models;

use app\models\GridForm;

/**
 * Unit-test модели GridForm
 *
 * Class GridFormTest
 */
class GridFormTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Проверка получения данных конфигурации.
     */
    public function testGetConfiguration()
    {
        $gridForm = new GridForm();
        $this->assertArraySubset([
            ['id' => 1, 'type' => 1, 'coef' => 4.0],
            ['id' => 2, 'type' => 2, 'coef' => 2.3],
            ['id' => 3, 'type' => 3, 'coef' => 3.5]
        ], $gridForm->getConfiguration());
    }

    /**
     * Проверяем на возможность занесения новой услуги в таблицу.
     */
    public function testAddService()
    {
        $gridForm = new GridForm();
        $this->assertTrue($gridForm->editService([
            'id' => '0',
            'type' => '4',
            'coef' => ''
        ]));
    }

    /**
     * Проверяем на возможность внесения изменений в таблицу.
     */
    public function testEditService()
    {
        $gridForm = new GridForm();
        $this->assertTrue($gridForm->editService([
            'id' => '2',
            'type' => '2',
            'coef' => '5.0'
        ]));
    }

    /**
     * Проверяем на возможность удалить указанные записи.
     */
    public function testRemoveServices()
    {
        $gridForm = new GridForm();
        $this->assertTrue($gridForm->removeServices(['3', '4']));
    }

    /**
     * Проверяем на возможность восстановления настроек по умолчанию.
     */
    public function testRestoreConfig()
    {
        $gridForm = new GridForm();
        $this->assertTrue($gridForm->restoreConfig());
    }
}
