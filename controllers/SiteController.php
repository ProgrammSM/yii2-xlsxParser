<?php

namespace app\controllers;

use yii\web\Controller;

/**
 * SiteController класс для главной страницы и вычисления
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
}
