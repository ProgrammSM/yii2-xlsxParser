<?php

/**
 * Функциональные тесты контроллера SiteController
 *
 * Class SiteCest
 */
class SiteCest
{
    /**
     * Устанавливаем главную страницу до начала выполнения тестов
     *
     * @param FunctionalTester $I
     */
    public function _before(\FunctionalTester $I)
    {
        $I->amOnPage(['/']);
    }

    /**
     * Проверяем наличие элементов на главной странице
     *
     * @param FunctionalTester $I
     */
    public function seeMainPage(\FunctionalTester $I)
    {
        $I->see('Калькулятор работ', 'h1');
        $I->see('Калькулятор работ', 'a');
        $I->see('Перейти к вычислениям!', 'a');
        $I->see('Вычисление', 'a');
        $I->see('Конфигурация', 'a');
    }

    /**
     * Проверяем переход на главную страницу по заголовку в шапке
     *
     * @param FunctionalTester $I
     */
    public function backToMainPage(\FunctionalTester $I)
    {
        $I->click('Калькулятор работ', 'a');
        $I->see('Калькулятор работ', 'h1');
    }

    /**
     * Проверка перехода на страницу calc.php (вычисление) по ссылке в
     * навигационной панели и возвращение на главную кликом по заголовку в
     * шапке
     *
     * @param FunctionalTester $I
     */
    public function goingOnNavToCalcPageAndBack(\FunctionalTester $I)
    {
        $I->amOnPage(['/']);
        $I->seeLink('Вычисление');
        $I->click('Вычисление');
        $I->see('Вычислить', 'h1');
        $I->click('Калькулятор работ');
        $I->see('Калькулятор работ', 'h1');
    }

    /**
     * Проверка перехода на страницу config/grid (конфигурация) по ссылке в
     * навигационной панели и возвращение на главную кликом по заголовку в
     * шапке
     *
     * @param FunctionalTester $I
     */
    public function goingOnNavToConfigPageAndBack(\FunctionalTester $I)
    {
        $I->amOnPage(['/']);
        $I->seeLink('Конфигурация');
        $I->click('Конфигурация');
        $I->see('Конфигурация', 'h1');
        $I->click('Калькулятор работ');
        $I->see('Калькулятор работ', 'h1');
    }

    /**
     * Проверка перехода на страницу calc.php (вычисление) по клику кнопки
     * "Перейти к вычислениям" в центре страницы и возвращение на главную
     * кликом по заголовку в шапке
     *
     * @param FunctionalTester $I
     */
    public function goingOnButtonToCalcPageAndBack(\FunctionalTester $I)
    {
        $I->amOnPage(['/']);
        $I->seeLink('Перейти к вычислениям!');
        $I->click('Перейти к вычислениям!');
        $I->see('Вычислить', 'h1');
        $I->click('Калькулятор работ', 'a');
        $I->see('Калькулятор работ', 'h1');
    }

    /**
     * Переход на site/calc и проверка наличия элементов на странице
     *
     * @param FunctionalTester $I
     */
    public function seeCalcPage(\FunctionalTester $I)
    {
        $I->amOnRoute('site/calc');
        $I->see('Вычислить', 'h1');
        $I->see('Отправить', 'button');
        $I->seeElement('input', ['type' => 'file']);
    }

    /**
     * Проверяем отправку файлов и просмотр результатов
     *
     * @param FunctionalTester $I
     */
    public function sendFile(\FunctionalTester $I)
    {
        $I->amOnRoute('site/calc');
        $I->attachFile('input[type="file"]', 'parsingFile.xlsx');
        $I->click('Отправить');
        $I->see('Стоимость работ', 'h1');
        $I->see('Ремонт отмостки', 'td');
    }
}
