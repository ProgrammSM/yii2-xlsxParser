<?php
use app\components\XlsxParserComponent;

/**
 * Unit-test для XlsxParserComponent
 */
class XlsxParserComponentTest extends \Codeception\Test\Unit
{
    public function testParsingFile()
    {
        $xlsxParser = new XlsxParserComponent();

        $pathXlsx = Yii::getAlias('tests') . '/_data/parsingFile.xlsx';

        $this->assertArraySubset([
            ["Ремонт отмостки", 35000.0],
            ["Ремонт фасада", 122500.0],
            ["Замена лампочки", 2300.0],
            ["Замена стояков ХГВС", 60000.0]
        ], $xlsxParser->parsingFile($pathXlsx, [
            [1, 4.0],
            [2, 2.3],
            [3, 3.5],
        ], 500.0));
    }
}
