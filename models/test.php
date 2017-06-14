<?php
/**
 * Created by PhpStorm.
 * User: suhomlinov_m
 * Date: 14.06.17
 * Time: 13:16
 */

namespace app\models;


use yii\base\Model;

class test extends Model
{
    public $msg;

    public function op () {
        \Yii::$app->xlsxParser->openXlsx('/home/suhomlinov_m/projects/www/html/yii2-xlsxParser/web/test.xlsx');

        if (\Yii::$app->xlsxParser->status) {
            $msg = 'Файл открыт';
        } else {
            $msg = \Yii::$app->xlsxParser->errorMsg;
        }
        $this->msg = $msg;
    }

    public function cell () {
        return \Yii::$app->xlsxParser->getCellValue(0, 1, 0);
    }

    public function getStatus () {
        return \Yii::$app->xlsxParser->status;
    }

    public function getError () {
        return \Yii::$app->xlsxParser->errorMsg;
    }

    public function getRowCount () {
        return \Yii::$app->xlsxParser->rowCount(0);
    }
}