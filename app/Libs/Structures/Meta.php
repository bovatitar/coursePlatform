<?php


namespace App\Libs\Structures;


class Meta
{
    public $page;
    public $totalItems;
    public $totalPage;
    public $perPage;

    public function __construct($page, $perPage, $totalPage, $totalItems)
    {
        $this->page = $page;
        $this->perPage = $perPage;
        $this->totalPage = $totalPage;
        $this->totalItems = $totalItems;
    }
}
