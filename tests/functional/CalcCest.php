<?php

class CalcCest
{
    public function _before(\FunctionalTester $I)
    {
        $I->amOnRoute('site/calc');
    }

    public function seeCalcPage(\FunctionalTester $I)
    {
        $I->see('Вычислить', 'h1');
        $I->see('Отправить', 'button');
    }
}
