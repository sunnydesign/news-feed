<?php


namespace app\modules\v1\models;

use yii\web\BadRequestHttpException;

trait CheckParamsTrait
{
    /**
     * @throws BadRequestHttpException
     */
    public function checkParams()
    {
        $rulesFields = [];
        foreach ($this->rules() as $rule) {
            foreach ($rule[0] as $field) {
                $rulesFields[] = $field;
            }
        }
        foreach ($this->params as $key => $param) {
            if(!in_array($key, $rulesFields)) {
                throw new BadRequestHttpException('Wrong params');
            }
        }
    }
}