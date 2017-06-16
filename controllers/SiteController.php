<?php

namespace app\controllers;

use app\models\CalcForm;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;

/**
 * SiteController класс для главной страницы и вычисления
 *
 * @package app\controllers
 */
class SiteController extends Controller
{
    /**
     * Отображаем главную сраницу.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

//    /**
//     * Вычисление стоимости работ из загружаемого xlsx файла
//     *
//     * @return string
//     */
//    public function actionCalc()
//    {
//        /**
//         * Модель экшена
//         *
//         * @var CalcForm
//         */
//        $model = new CalcForm();
//
//        if (Yii::$app->request->isPost) {
//            // Загружаем файл
//            $model->file = UploadedFile::getInstance($model, 'file');
//            if ($path = $model->upload()) {
//                // Загружаем конфигурацию из базы данных в виде массива
//                $config = $model->getConfiguration();
//                // Компонентом xlsxParser производим парсинг и вычисление
//                $model->data = Yii::$app->xlsxParser->parse($path, $config,
//                    500.0);
//
//                return $this->render('table', ['model' => $model]);
//            }
//        }
//        return $this->render('calc', ['model' => $model]);
//    }
}
