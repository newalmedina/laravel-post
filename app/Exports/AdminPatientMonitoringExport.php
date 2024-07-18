<?php

namespace App\Exports;

use App\Models\Diagnosi;
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

class AdminPatientMonitoringExport implements FromQuery, WithHeadings, WithMapping, WithTitle, WithStrictNullComparison
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
            trans('patient-monitorings/admin_lang.fields.date'),
            trans('patient-monitorings/admin_lang.fields.patient'),
            trans('patient-monitorings/admin_lang.fields.center'),
            trans('patient-monitorings/admin_lang.fields.height'),
            trans('patient-monitorings/admin_lang.fields.weight'),
            trans('patient-monitorings/admin_lang.fields.temperature'),
            trans('patient-monitorings/admin_lang.fields.heart_rate'),
            trans('patient-monitorings/admin_lang.fields.blood_presure'),
            trans('patient-monitorings/admin_lang.fields.rheumatoid_factor'),
            trans('patient-monitorings/admin_lang.fields.motive'),
            trans('patient-monitorings/admin_lang.fields.physical_exploration'),
            trans('patient-monitorings/admin_lang.fields.symptoms'),
            trans('patient-monitorings/admin_lang.fields.diagnosis_id'),
            trans('patient-monitorings/admin_lang.fields.comment'),
        ];
    }
    public function map($fila): array
    {

        $diagnosis = Diagnosi::find($fila->id);


        return [
            !empty($fila->date) ? Carbon::createFromFormat("Y-m-d", $fila->date)->format("d/m/Y") : null,
            $fila->patient,
            $fila->center,
            $fila->height,
            $fila->weight,
            $fila->temperature,
            $fila->heart_rate,
            $fila->blood_presure,
            $fila->rheumatoid_factor,
            strip_tags($fila->motive),
            strip_tags($fila->physical_exploration),
            strip_tags($fila->symptoms),
            strip_tags($diagnosis->diagnosisNameStringFormatted),
            strip_tags($fila->comment),

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
