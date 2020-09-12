<?php
namespace app\modules\v1\models;

use \yii\db\Query;

trait ChildsTrait
{
    /**
     * @param array $params
     * @param string $parent
     * @return array
     */
    public function getChild($params, $parent) {
        return (new Query())
            ->select([$params['key']])
            ->from($params['table'])
            ->where([$params['refKey'] => $parent])
            ->all();
    }

    /**
     * @param array $params
     * @param string $parent
     * @param array|null $storage
     * @return array
     */
    public function findChildIds($params, $parent, &$storage = []) {
        $storage[] = $parent;
        foreach ($this->getChild($params, $parent) as $child) {
            $this->findChildIds($params, $child[$params['key']], $storage);
        }

        return $storage;
    }
}