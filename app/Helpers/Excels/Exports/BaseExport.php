<?php

namespace App\Helpers\Excels\Exports;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BaseExport implements FromCollection, ShouldAutoSize
{
    protected $collection;
    public function __construct($collection)
    {
        $this->collection = $collection;
    }
    public function collection(): Collection
    {
       return $this->collection;
    }
}
