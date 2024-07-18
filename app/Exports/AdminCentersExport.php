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

class AdminCentersExport implements FromQuery, WithHeadings, WithMapping, WithTitle, WithStrictNullComparison
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
            trans('centers/admin_lang.fields.name'),
            trans('centers/admin_lang.fields.phone'),
            trans('centers/admin_lang.fields.email'),
            trans('centers/admin_lang.fields.province_id'),
            trans('centers/admin_lang.fields.municipio_id'),
            trans('centers/admin_lang.fields.address'),
            trans('centers/admin_lang.fields.active'),
            trans('centers/admin_lang.fields.default'),
            trans('centers/admin_lang.fields.schedule'),
            trans('centers/admin_lang.fields.specialities'),
        ];
    }
    public function map($fila): array
    {
        return [
            $fila->name,
            $fila->phone,
            $fila->email,
            $fila->province,
            $fila->municipio,
            $fila->address,
            $fila->active ? trans('general/admin_lang.yes') : trans('general/admin_lang.no'),
            $fila->default ? trans('general/admin_lang.yes') : trans('general/admin_lang.no'),
            $fila->schedule,
            $fila->specialities,
        ];
    }

    public function title(): string
    {
        return trans('centers/admin_lang.centers');
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
