<?php

namespace app\controllers;

use app\models\GridForm;
use yii\web\Controller;
use \yii\helpers\BaseJson;
use yii\web\HttpException;

/**
 * Контроллер страницы конфигурации
 *
 * Class ConfigController
 */
class ConfigController extends Controller
{
    /**
     * @var string действие по умолчанию
     */
    public $defaultAction = 'grid';

    /**
     * Отображение шаблона с конфигурацией хранящейся в базе данных
     *
     * @return mixed
     */
    public function actionGrid()
    {
        $model = new GridForm();
        $data = [
            'title' => 'Конфигурация',
            'config' => $model->getConfiguration()
        ];
        return $this->render('grid', $data);
    }

    /**
     * Добавление строки с работой
     *
     * @return \yii\web\Response
     * @throws HttpException
     */
    public function actionAdd()
    {
        $model = new GridForm();
        if (!$model->addService()) {
            throw new HttpException(422, 'Ошибка добавления');
        }
        return $this->redirect('index.php?r=config');
    }

    /**
     * Удаление указанных элементов
     *
     * @param string $id строка в формате JSON вида {"0":4} где "0" -
     *                        номер элемента массива, который сформируется в
     *                        PHP, 4 - передаваемый ID удаляемого объекта
     *
     * @return \yii\web\Response
     */
    public function actionRemove($id)
    {
        $model = new GridForm();
        // Декодируем формат JSON в PHP и передаём в модель
        $model->removeServices(BaseJson::decode($id));
        return $this->redirect('index.php?r=config');
    }

    /**
     * Редактирование записей в услугах
     *
     * @param null|string $service строка в формате JSON вида
     *                             {"id":"3","type":"3","coef":"5.0"}
     *
     * @return \yii\web\Response
     * @throws HttpException
     */
    public function actionEdit($service)
    {
        $model = new GridForm();
        // Декодируем формат JSON в PHP и передаём в модель
        if (!$model->editService(BaseJson::decode($service))) {
            throw new HttpException(422, 'Ошибка редактирования');
        }
        return $this->redirect('index.php?r=config');
    }

    /**
     * Восстановление настроек по умолчанию
     *
     * @return \yii\web\Response
     * @throws HttpException
     */
    public function actionRestore() {
        $model = new GridForm();
        if (!$model->restoreConfig()) {
            throw new HttpException(422, 'Ошибка восстановления');
        }
        return $this->redirect('index.php?r=config');
    }
}
