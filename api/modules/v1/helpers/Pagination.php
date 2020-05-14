<?php

namespace api\modules\v1\helpers;

class Pagination
{
    const LIMIT = 1000;

    private int $offset;

    private int $page;

    public function __construct($page)
    {
        $this->setPage($page ?? 1);
    }

    public function setOffset(int $offset): self
    {
        $this->offset = $offset;

        return $this;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function setPage(int $page): self
    {
        $this->page = $page;
        $this->offset = ($this->page - 1) * self::LIMIT;

        return $this;
    }

    public function getPage(): int
    {
        return $this->page;
    }

}