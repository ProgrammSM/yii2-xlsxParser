<?php
/**
 * Функциональные тесты контроллера ConfigCest
 *
 * Class ConfigCest
 */
class ConfigCest
{
    /**
     * Устанавливаем страницу config/grid до начала выполнения тестов
     *
     * @param FunctionalTester $I
     */
    public function _before(\FunctionalTester $I)
    {
        $I->amOnPage(['config/grid']);
    }

    /**
     * Осматриваем наличие элементов в представлении grid
     *
     * @param FunctionalTester $I
     */
    public function seeGridPage(\FunctionalTester $I)
    {
        $I->see('Конфигурация', 'h1');
        $I->seeElement("table");
        $I->see('Добавить строку', 'button');
        $I->see('Удалить выделенное', 'button');
    }
}
