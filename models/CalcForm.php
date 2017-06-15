<?php

namespace app\models;

use yii\base\Model;
use \yii\web\UploadedFile;

/**
 * Вычисление
 *
 * Class ClacForm
 */
class CalcForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;

    /**
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by [[validate()]] to check if attribute values are valid.
     * Child classes may override this method to declare different validation rules.
     *
     * Each rule is an array with the following structure:
     *
     * ```php
     * [
     *     ['attribute1', 'attribute2'],
     *     'validator type',
     *     'on' => ['scenario1', 'scenario2'],
     *     //...other parameters...
     * ]
     * ```
     *
     * where
     *
     *  - attribute list: required, specifies the attributes array to be validated, for single attribute you can pass a string;
     *  - validator type: required, specifies the validator to be used. It can be a built-in validator name,
     *    a method name of the model class, an anonymous function, or a validator class name.
     *  - on: optional, specifies the [[scenario|scenarios]] array in which the validation
     *    rule can be applied. If this option is not set, the rule will apply to all scenarios.
     *  - additional name-value pairs can be specified to initialize the corresponding validator properties.
     *    Please refer to individual validator class API for possible properties.
     *
     * A validator can be either an object of a class extending [[Validator]], or a model class method
     * (called *inline validator*) that has the following signature:
     *
     * ```php
     * // $params refers to validation parameters given in the rule
     * function validatorName($attribute, $params)
     * ```
     *
     * In the above `$attribute` refers to the attribute currently being validated while `$params` contains an array of
     * validator configuration options such as `max` in case of `string` validator. The value of the attribute currently being validated
     * can be accessed as `$this->$attribute`. Note the `$` before `attribute`; this is taking the value of the variable
     * `$attribute` and using it as the name of the property to access.
     *
     * Yii also provides a set of [[Validator::builtInValidators|built-in validators]].
     * Each one has an alias name which can be used when specifying a validation rule.
     *
     * Below are some examples:
     *
     * ```php
     * [
     *     // built-in "required" validator
     *     [['username', 'password'], 'required'],
     *     // built-in "string" validator customized with "min" and "max" properties
     *     ['username', 'string', 'min' => 3, 'max' => 12],
     *     // built-in "compare" validator that is used in "register" scenario only
     *     ['password', 'compare', 'compareAttribute' => 'password2', 'on' => 'register'],
     *     // an inline validator defined via the "authenticate()" method in the model class
     *     ['password', 'authenticate', 'on' => 'login'],
     *     // a validator of class "DateRangeValidator"
     *     ['dateRange', 'DateRangeValidator'],
     * ];
     * ```
     *
     * Note, in order to inherit rules defined in the parent class, a child class needs to
     * merge the parent rules with child rules using functions such as `array_merge()`.
     *
     * @return array validation rules
     * @see scenarios()
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx'],
        ];
    }

    /**
     * Загрузка файла
     *
     * @return bool|string В случае успешной загрузки возвращается имя файла
     *                     иначе возвращается false
     */
    public function upload()
    {
        /**
         * Получаем путь директории для сохранения
         *
         * @var string $dirUpload
         */
        $dirUpload = Yii::getAlias('@app') . "/uploads";

        /**
         * Проверяем существование директории для сохранения
         */
        if (!file_exists(Yii::getAlias('@app') . '/uploads')) {
            mkdir($dirUpload, 0775, true);
        }

        /**
         * Сохранение файла, если проверка пройдена успешно
         */
        if ($this->validate()) {
            $fileName = $this->file->baseName . '.' . $this->file->extension;
            $this->file->saveAs('uploads/' . $fileName);
            return $fileName;
        } else {
            return false;
        }
    }


}
