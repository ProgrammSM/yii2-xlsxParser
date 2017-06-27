<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Модель для работы с таблицей Service в DB
 */
class Service extends ActiveRecord
{
    /**
     * Сценарий добавления
     */
    const SCENARIO_NEW = 'new';

    /**
     * Сценарий редактирования
     */
    const SCENARIO_EDIT = 'edit';

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        /**
         * Сценарий для массового присваивания указанных атрибутов при
         * операции редактирования услуги
         */
        $scenarios[self::SCENARIO_EDIT] = ['type', 'coef'];
        $scenarios[self::SCENARIO_NEW] = ['type', 'coef'];
        return $scenarios;
    }
}
