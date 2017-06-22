<?php

namespace app\controllers;

use yii\web\Controller;

/**
 * Контроллер страницы конфигурации
 *
 * Class ConfigController
 */
class ConfigController extends Controller
{
    /**
     * Отображение шаблона с конфигурацией хранящейся в базе данных
     *
     * @return mixed
     */
    public function actionGrid()
    {
        $view = 'grid';
        $data = ['title' => 'Конфигурация'];
        return $this->render($view, $data);
    }
}
