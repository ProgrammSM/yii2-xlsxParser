<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Модель для работы с данными конфигурации
 *
 * Class GridForm
 */
class GridForm extends Model
{
    /**
     * Получаем конфигурацию для калькуляции и формирования из базы данных
     * SQLite.
     *
     * @return array[] [['id' => $id, 'type' => $type, 'coef' => $coef],[...]]
     */
    public function getConfiguration()
    {
        // Делаем SQL-запрос в таблицу services
        $services = Service::find()->asArray()->all();
        $result = [];
        foreach ($services as $srv) {
            $result[] = [
                'id' => $srv['id'],
                'type' => $srv['type'],
                'coef' => $srv['coef']
            ];
        }
        return $result;
    }

    /**
     * Добавление новой услуги
     *
     * @param string[] $data массив с данными новой услуги
     *
     * @return bool результат выполнения
     */
    public function newService($data) {
        $service = new Service();
        $service->scenario = 'newOrEdit';
        $service->attributes = $data;
        return $service->save();
    }

    /**
     * Удаление указанных услуг
     *
     * @param string[] $data идентификаторы удаляемых услуг
     *
     * @return bool
     */
    public function removeServices($data)
    {
        $result = true;
        foreach ($data as $id) {
            if ($service = Service::findOne($id)) {
                if ($service->delete() === false) {
                    $result = false;
                    break;
                }
            } else {
                $result = false;
            }
        }
        return $result;
    }

    /**
     * Редактирование данных услуги
     *
     * @param string[] $data массив содержащий изменённые данные
     *
     * @return bool результат выполнения
     */
    public function editService($data)
    {
        $result = false;
        if (!empty($data)) {
            if ($service = Service::findOne($data['id'])) {
                $service->scenario = 'newOrEdit';
                $service->attributes = $data;
                $result = $service->save();
            }
        } else {
            $result = true;
        }
        return $result;
    }

    /**
     * Восстановление базы данных (конфигурации по умолчанию) из резервной
     *
     * @return bool
     */
    public function restoreConfig()
    {
        // Закрываем соединение с базой данных для возможности заменить файл .db
        Yii::$app->db->close();
        $result = copy(
            Yii::$app->params['dbPath'] . '/data_back.db',
            Yii::$app->params['dbPath'] . '/data.db'
        );
        // Запускаем соединение для дальнейшей работы c базой данных
        Yii::$app->db->init();
        return $result;
    }
}
