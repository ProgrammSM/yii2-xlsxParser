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
    const SCENARIO_EDIT = 'editService';

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
     * Добавление новой строки в базу данных для добавление конфигурации услуги
     *
     * @return bool
     */
    public function addService()
    {
        $service = new Service();
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
            $service = Service::findOne($id);
            if ($service->delete() === false) {
                $result = false;
                break;
            }
        }
        return $result;
    }

    /**
     * Редактирование данных услуг
     *
     * @param string[] $data массив содержащий изменённые данные
     *
     * @return bool результат выполнения
     */
    public function editService($data)
    {
        $service = Service::findOne($data['id']);
        $service->scenario = 'edit';
        $service->attributes = $data;
        return $service->save();
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
