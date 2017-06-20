<?php

namespace app\controllers;

use app\models\CalcForm;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;

/**
 * SiteController класс для главной страницы, вычисления и отображения
 * результатов вычисления.
 *
 * @package app\controllers
 */
class SiteController extends Controller
{
    /**
     * Отображаем главную страницу.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Отображаем страницу с функционалом или результатами вычисления.
     *
     * @return string
     */
    public function actionCalc()
    {
        /**
         * @var CalcForm
         */
        $model = new CalcForm();

        /**
         * @var String $view представление по умолчанию
         */
        $view = 'calc';

        /**
         * @var mixed[] $data данные передаваемые в представление по умолчанию
         */
        $data = ['model' => $model, 'title' => 'Вычислить'];
        if (Yii::$app->request->isPost) {
            // Принимаем входящий файл.
            $uploadedFile = UploadedFile::getInstance($model, 'file');
            // Загружаем конфигурацию с базы данных.
            $config = $model->getConfiguration();
            $view = 'result';
            /**
             * Передаём путь на временный файл в компонент xlsxParser,
             * конфигурацию и зарплатную ставку и возвращаем результат в $data.
             */
            $data
                = [
                'data' => Yii::$app->xlsxParser->parse($uploadedFile->tempName,
                    $config, 500.0),
                'title' => 'Стоимость работ'
            ];
        }
        return $this->render($view, $data);
    }
}
