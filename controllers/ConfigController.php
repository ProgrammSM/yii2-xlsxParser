<?php

namespace app\controllers;

use app\models\GridForm;
use yii\web\Controller;
use \yii\helpers\BaseJson;

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
     * @param null|string $err
     *
     * @return mixed
     */
    public function actionGrid($err = null)
    {
        $model = new GridForm();
        $data = [
            'title' => 'Конфигурация',
            'config' => $model->getConfiguration(),
            'err' => $err
        ];
        return $this->render('grid', $data);
    }

    /**
     * Добавление строки с работой
     *
     * @return \yii\web\Response
     */
    public function actionAdd()
    {
        $url = 'index.php?r=config%2Fgrid';
        $model = new GridForm();
        if (!$model->addService()) {
            $url .= '&err=Ошибка%20добавления';
        }
        return $this->redirect($url);
    }

    /**
     * Удаление указанных элементов
     *
     * @param null|string $id строка в формате JSON вида {"0":4} где "0" -
     *                        номер элемента массива, который сформируется в
     *                        PHP, 4 - передаваемый ID удаляемого объекта
     *
     * @return \yii\web\Response
     */
    public function actionRemove($id = null)
    {
        $url = 'index.php?r=config%2Fgrid';
        if ($id !== null) {
            $model = new GridForm();
            // Декодируем формат JSON в PHP и передаём в модель
            if (!$model->removeServices(BaseJson::decode($id))) {
                $url .= '&err=Ошибка%20удаления';
            }
        } else {
            $url .= '&err=Ошибка%20удаления';
        }
        return $this->redirect($url);
    }

    /**
     * Редактирование записей в услугах
     *
     * @param null|string $service строка в формате JSON вида
     *                             {"id":"3","type":"3","coef":"5.0"}
     *
     * @return \yii\web\Response
     */
    public function actionEdit($service = null)
    {
        $url = 'index.php?r=config%2Fgrid';
        if ($service !== null) {
            $model = new GridForm();
            // Декодируем формат JSON в PHP и передаём в модель
            if (!$model->editService(BaseJson::decode($service))) {
                $url .= '&err=Ошибка%20редактирования';
            }
        }
        return $this->redirect($url);
    }

    /**
     * Восстановление настроек по умолчанию
     *
     * @return \yii\web\Response
     */
    public function actionRestore() {
        $url = 'index.php?r=config%2Fgrid';
        $model = new GridForm();
        if (!$model->restoreConfig()) {
            $url .= '&err=Ошибка%20восстановления';
        }
        return $this->redirect($url);
    }
}
