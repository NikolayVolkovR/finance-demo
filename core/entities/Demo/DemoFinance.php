<?php

namespace core\entities\Demo;

use Yii;

/**
 * This is the model class for table "{{%demo_finance}}".
 *
 * @property int $id
 * @property string $email Email
 * @property string $name ФИО
 */
class DemoFinance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%demo_finance}}';
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'name' => 'Name',
        ];
    }
}
