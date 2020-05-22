<?php

namespace api\modules\v1\models;

use api\modules\v1\helpers\Pagination;
use Yii;

class Files
{
    private string $dir;

    private Pagination $pagination;

    public function __construct(string $dir, Pagination $pagination)
    {
        $this->dir = $dir;
        $this->pagination = $pagination;
    }

    private function getMaskForScan(): string
    {
        return realpath($this->dir) . '/*';
    }

    private function getFilesList(): \LimitIterator
    {
        $iterator = new \GlobIterator($this->getMaskForScan());

        return new \LimitIterator($iterator, $this->pagination->getOffset(), $this->pagination::LIMIT);
    }

    private function prepareFilesList(): array
    {
        $files = [];
        $iterator = $this->getFilesList();

        foreach($iterator as $entry) {
            $files[] = [
                'id' => $this->getId($iterator->getPosition()),
                'inode' => $entry->getInode(),
                'name' => $entry->getFilename(),
                'size' => $entry->getSize(),
                'realpath' => $entry->getRealPath(),
                'link' => Yii::$app->request->pathInfo . DIRECTORY_SEPARATOR . $this->getId($iterator->getPosition())
            ];
        }

        return $files;
    }

    public function getId(int $iteratorPosition): int
    {
        return ($this->pagination->getPage() - 1) * $this->pagination::LIMIT + $iteratorPosition;
    }

    public function getAll(): array
    {
        return $this->prepareFilesList();
    }

    public function getOne(int $id): ?array
    {
        $index = $id % $this->pagination::LIMIT;

        return $this->prepareFilesList()[$index] ?? null;
    }

}
