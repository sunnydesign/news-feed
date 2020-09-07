<?php


namespace app\modules\v1\models;


trait ChildsTrait
{
    /**
     * @param array $params
     * @param string $parent
     * @return array
     */
    public function getChild($params, $parent) {
        return (new \yii\db\Query())
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
    public function getChilds($params, $parent, &$storage = []) {
        $storage[] = $parent;
        foreach ($this->getChild($params, $parent) as $child) {
            $this->getChilds($params, $child[$params['key']], $storage);
        }
        return $storage;
    }
}