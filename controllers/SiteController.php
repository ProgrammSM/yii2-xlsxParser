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

        if (Yii::$app->request->isPost) {
            // Принимаем входящий файл.
            $uploadedFile = UploadedFile::getInstance($model, 'file');
            // Загружаем конфигурацию с базы данных.
            $config = $model->getConfiguration();
            /** Передаём путь на временный файл в компонент xlsxParser,
             * конфигурацию и зарплатную ставку. */
            $model->data = Yii::$app->xlsxParser->parse($uploadedFile->tempName,
                $config,
                500.0);
            return $this->render('result', ['model' => $model]);
        }
        return $this->render('calc', ['model' => $model]);
    }
}
