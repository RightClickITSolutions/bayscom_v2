<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ReportExport implements FromArray , ShouldAutoSize, WithDrawings
{
    //use ;
    
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('MOFAD');
        $drawing->setDescription('MOFAD Logo');
        $drawing->setPath(public_path('assets/img/mofad-logo.png'));
        $drawing->setHeight(90);
        $drawing->setCoordinates('B1');

        return $drawing;
    }

    
}