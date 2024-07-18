<?php

namespace App\Exports;

use App\Models\PatientMedicineDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;

use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class AdminPatientMedicineExport implements FromQuery, WithHeadings, WithMapping, WithTitle, WithStrictNullComparison
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
            trans('patient-medicines/admin_lang.fields.date'),
            trans('patient-medicines/admin_lang.fields.patient'),
            trans('patient-medicines/admin_lang.fields.medicine'),
            // trans('patient-medicines/admin_lang.fields.amount'),
            trans('patient-medicines/admin_lang.fields.dosis'),
            trans('patient-medicines/admin_lang.fields.period'),
            trans('patient-medicines/admin_lang.fields.center'),
        ];
    }
    public function map($fila): array
    {

        return [
            !empty($fila->date) ? Carbon::createFromFormat("Y-m-d", $fila->date)->format("d/m/Y") : null,
            $fila->patient,
            $fila->medicine,
            // $fila->amount,
            $fila->dosis,
            $fila->period,
            $fila->center,
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
