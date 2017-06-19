<?php

/**
 * Функциональные тесты site/calc
 *
 * Class CalcCest
 */
class CalcCest
{
    /**
     * Устанавливаем site/calc страницей нахохдения до начала выполнения тестов
     *
     * @param FunctionalTester $I
     */
    public function _before(\FunctionalTester $I)
    {
        $I->amOnRoute('site/calc');
    }

    /**
     * Проверка наличия элементов на странице
     *
     * @param FunctionalTester $I
     */
    public function seeCalcPage(\FunctionalTester $I)
    {
        $I->see('Вычислить', 'h1');
        $I->see('Отправить', 'button');
        $I->seeElement('input', ['type' => 'file']);
    }
}
