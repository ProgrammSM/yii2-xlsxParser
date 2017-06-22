<?php

namespace app\controllers;

use app\models\CalcForm;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;

/**
 * SiteController класс для главной страницы, вычисления и отображения
 * результатов вычисления.
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
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->validate()) {
                $view = 'result';
                // Формируем данные для представления result
                $data = [
                    'data' => $model->getData(Yii::$app->params['rate']),
                    'title' => 'Стоимость работ'
                ];
            }
        }
        return $this->render($view, $data);
    }
}
