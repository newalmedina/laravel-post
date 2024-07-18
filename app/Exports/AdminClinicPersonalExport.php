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

class AdminClinicPersonalExport implements FromQuery, WithHeadings, WithMapping, WithTitle, WithStrictNullComparison
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
            trans('clinic-personal/admin_lang.fields.name'),
            trans('clinic-personal/admin_lang.fields.phone'),
            trans('clinic-personal/admin_lang.fields.email'),
            trans('clinic-personal/admin_lang.fields.exequatur'),
            trans('clinic-personal/admin_lang.fields.specialization_id'),
        ];
    }
    public function map($fila): array
    {

        $specializations = DB::table('doctor_specializations')
            ->join("medical_specializations", "medical_specializations.id", "=", "doctor_specializations.specialization_id")
            ->where("doctor_specializations.user_id", $fila->id)
            ->pluck("medical_specializations.name");


        return [
            $fila->first_name . ' ' .  $fila->last_name,
            $fila->phone,
            $fila->email,
            $fila->exequatur,
            $specializations->implode(', ')

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
