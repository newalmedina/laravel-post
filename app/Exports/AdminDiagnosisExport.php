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

class AdminDiagnosisExport implements FromQuery, WithHeadings, WithMapping, WithTitle, WithStrictNullComparison
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
            trans('diagnosis/admin_lang.fields.name'),
            trans('diagnosis/admin_lang.fields.active'),
        ];
    }
    public function map($fila): array
    {
        return [
            $fila->name,

            $fila->active ? trans('general/admin_lang.yes') : trans('general/admin_lang.no'),

        ];
    }

    public function title(): string
    {
        return trans('diagnosis/admin_lang.diagnosis');
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
