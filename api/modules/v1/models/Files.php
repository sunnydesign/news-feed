<?php

namespace api\modules\v1\models;

class Files
{
    private $dir;

    public function __construct($dir)
    {
        $this->dir = $dir;
    }

    private function getMaskForScan()
    {
        return realpath($this->dir) . '/*';
    }

    private function getFilesList()
    {
        $files = [];
        $iterator = new \GlobIterator($this->getMaskForScan());

        foreach($iterator as $entry) {
            $files[] = [
                'inode' => $entry->getInode(),
                'name' => $entry->getFilename(),
                'size' => $entry->getSize(),
                'realpath' => $entry->getRealPath(),
            ];
        }

        return $files;
    }

    public function getAll()
    {
        return $this->getFilesList();
    }

    public function getOne($id)
    {
        return $this->getFilesList()[$id] ?? null;
    }
}
