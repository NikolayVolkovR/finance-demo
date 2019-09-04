<?php
namespace core\forms\Demo;

use yii\base\Model;

class FinanceForm extends Model
{
    public $name;
    public $email;

    public function rules(): array
    {
        return [
            [['name', 'email'], 'required'],
            ['email', 'email'],
            [['name', 'email'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'ФИО',
            'email' => 'email',
        ];
    }
}
