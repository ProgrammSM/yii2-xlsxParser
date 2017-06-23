<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\Html;

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
        $services = Services::find()->asArray()->all();
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
        $result = false;
        if (\Yii::$app->db->createCommand()->insert('services', [])->execute()
            > 0
        ) {
            $result = true;
        }
        return $result;
    }

    /**
     * Удаление указанных услуг
     *
     * @param string[] $array идентификаторы удаляемых услуг
     *
     * @return bool
     */
    public function removeServices($array)
    {
        $result = false;
        if (count($array) > 0) {
            // Задаём счётчик выполненных операций
            $counter = 0;
            foreach ($array as $id) {
                $counter += \Yii::$app->db->createCommand()
                    ->delete('services', 'id = ' . Html::encode($id))
                    ->execute();
            }
            if ($counter > 0) {
                $result = true;
            }
        }
        return $result;
    }

    /**
     * Редактирование данных услуг
     *
     * @param mixed[] $array массив содержащий изменённые данные
     *
     * @return bool результат выполнения
     */
    public function editService($array)
    {
        $result = false;
        if (\Yii::$app->db->createCommand()->update('services', [
                'type' => (integer)Html::encode($array['type']),
                'coef' => (float)Html::encode($array['coef'])
            ], 'id = ' . Html::encode($array['id']))->execute() > 0
        ) {
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
