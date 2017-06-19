<?php

class IndexCest
{
    public function _before(\FunctionalTester $I)
    {
        $I->amOnPage(['/']);
    }

    public function seeMainPage(\FunctionalTester $I)
    {
        $I->see('Калькулятор работ', 'h1');
        $I->see('Калькулятор работ', 'a');
        $I->see('Перейти к вычислениям!', 'a');
        $I->see('Вычисление', 'a');
        $I->see('Конфигурация', 'a');
    }

    public function backToMainPage(\FunctionalTester $I)
    {
        $I->click('Калькулятор работ', 'a');
        $I->see('Калькулятор работ', 'h1');
    }
}
