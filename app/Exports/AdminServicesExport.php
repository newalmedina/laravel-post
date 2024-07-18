<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;

use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class AdminServicesExport implements FromQuery, WithHeadings, WithMapping, WithTitle, WithStrictNullComparison
{


    public function __construct(protected $query)
    {
    }

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {

        return [
            trans('services/admin_lang.fields.name'),
            trans('services/admin_lang.fields.price'),
            trans('services/admin_lang.fields.description'),
            trans('services/admin_lang.fields.active')
        ];
    }
    public function map($fila): array
    {
        return [
            $fila->name,
            $fila->price,
            $fila->description,
            $fila->active ? trans('general/admin_lang.yes') : trans('general/admin_lang.no'),

        ];
    }

    public function title(): string
    {
        return trans('services/admin_lang.services');
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:J1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => Color::COLOR_WHITE],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF0000FF'], // Cambiar a tu color deseado
                    ],
                ]);
            },
        ];
    }
}
