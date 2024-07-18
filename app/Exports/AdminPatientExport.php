<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;

use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class AdminPatientExport implements FromQuery, WithHeadings, WithMapping, WithTitle, WithStrictNullComparison
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
            trans('patients/admin_lang.fields.first_name'),
            trans('patients/admin_lang.fields.phone'),
            trans('patients/admin_lang.fields.mobile'),
            trans('patients/admin_lang.fields.email'),
            trans('patients/admin_lang.fields.birthday'),
            trans('patients/admin_lang.fields.identification'),
            trans('patients/admin_lang.fields.province_id'),
            trans('patients/admin_lang.fields.municipio_id'),
            trans('patients/admin_lang.fields.address'),
        ];
    }
    public function map($fila): array
    {
        return [
            $fila->patient,
            $fila->phone,
            $fila->mobile,
            $fila->email,
            $fila->birthday,
            $fila->identification,
            $fila->province,
            $fila->municipio,
            $fila->address
        ];
    }

    public function title(): string
    {
        return trans('insurance-carriers/admin_lang.insurance-carriers');
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
