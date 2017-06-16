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

//    public function goingOnNavToCalcPageAndBack(\FunctionalTester $I)
//    {
//        $I->amOnPage(['/']);
//        $I->seeLink('Вычисление');
//        $I->click('Вычисление');
//        $I->see('Вычислить', 'h1');
//        $I->click('Калькулятор работ');
//        $I->see('Калькулятор работ', 'h1');
//    }
//
//    public function goingOnButtonToCalcPageAndBack(\FunctionalTester $I)
//    {
//        $I->amOnPage(['/']);
//        $I->seeLink('Перейти к вычислениям!');
//        $I->click('Перейти к вычислениям!');
//        $I->see('Вычислить', 'h1');
//        $I->click('Калькулятор работ', 'a');
//        $I->see('Калькулятор работ', 'h1');
//    }
}
