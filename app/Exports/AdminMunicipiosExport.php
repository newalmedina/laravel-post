<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AdminMunicipiosExport implements FromQuery, WithHeadings, WithMapping, WithTitle, WithStrictNullComparison
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
            trans('municipios/admin_lang.fields.name'),
            trans('municipios/admin_lang.fields.province_id'),
            trans('municipios/admin_lang.fields.active'),
        ];
    }
    public function map($fila): array
    {
        return [
            $fila->name,
            $fila->province,

            $fila->active ? trans('general/admin_lang.yes') : trans('general/admin_lang.no'),

        ];
    }

    public function title(): string
    {
        return trans('municipios/admin_lang.municipios');
    }
    public function style(Worksheet $sheet)
    {
        $sheet->getStyle('A1:B1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'C0C0C0', // Puedes cambiar el color a tu preferencia.
                ],
            ],
        ]);
    }
}
