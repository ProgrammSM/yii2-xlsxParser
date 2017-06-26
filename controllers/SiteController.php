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

    /**
     * Declares external actions for the controller.
     * This method is meant to be overwritten to declare external actions for the controller.
     * It should return an array, with array keys being action IDs, and array values the corresponding
     * action class names or action configuration arrays. For example,
     *
     * ```php
     * return [
     *     'action1' => 'app\components\Action1',
     *     'action2' => [
     *         'class' => 'app\components\Action2',
     *         'property1' => 'value1',
     *         'property2' => 'value2',
     *     ],
     * ];
     * ```
     *
     * [[\Yii::createObject()]] will be used later to create the requested action
     * using the configuration provided here.
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}
