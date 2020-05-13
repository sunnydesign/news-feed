<?php

namespace api\modules\v1\models;

class Files
{
    private $dir;

    public function __construct($dir)
    {
        $this->dir = $dir;
    }

    private function getMaskForScan(): string
    {
        return realpath($this->dir) . '/*';
    }

    private function getFilesList($limit = 1000, $offset = 0): \LimitIterator
    {
        $iterator = new \GlobIterator($this->getMaskForScan());

        return new \LimitIterator($iterator, $offset, $limit);
    }

    private function prepareFilesList(): array
    {
        $start = microtime(true);
        $files = [];

        foreach($this->getFilesList() as $entry) {
            $files[] = [
                'inode' => $entry->getInode(),
                'name' => $entry->getFilename(),
                'size' => $entry->getSize(),
                'realpath' => $entry->getRealPath(),
            ];
        }

        return array_merge(['t' => microtime(true) - $start], $files);
    }

    public function getAll(): array
    {
        return $this->prepareFilesList();
    }

    public function getOne($id): ?array
    {
        return $this->prepareFilesList()[$id] ?? null;
    }

}
