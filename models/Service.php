<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Модель для работы с таблицей Service в DB
 */
class Service extends ActiveRecord
{
    const SCENARIO_EDIT = 'edit';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        /**
         * Сценарий для массового присваивания указанных атрибутов при
         * операции редактирования услуги
         */
        $scenarios[self::SCENARIO_EDIT] = ['type', 'coef'];
        return $scenarios;
    }
}
