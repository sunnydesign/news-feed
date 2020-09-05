<?php


namespace api\modules\v1\models;


trait ChildsTrait
{
    public function getChild($params, $parent) {
        return (new \yii\db\Query())
            ->select([$params['key']])
            ->from($params['table'])
            ->where([$params['refKey'] => $parent])
            ->all();
    }

    public function getChilds($params, $parent, &$storage = []) {
        $storage[] = $parent;
        foreach ($this->getChild($params, $parent) as $child) {
            $this->getChilds($params, $child[$params['key']], $storage);
        }
        return $storage;
    }

//    public function getChild($table, $key, $refKey, $parent) {
//        return (new \yii\db\Query())
//            ->select([$key])
//            ->from($table)
//            ->where([$refKey => $parent])
//            ->all();
//    }
//
//    public function getChilds($table, $key, $refKey, $parent, &$storage = []) {
//        $storage[] = $parent;
//        foreach ($this->getChild($table, $key, $refKey, $parent) as $child) {
//            $this->getChilds($table, $key, $refKey, $child[$key], $storage);
//        }
//        return $storage;
//    }
}