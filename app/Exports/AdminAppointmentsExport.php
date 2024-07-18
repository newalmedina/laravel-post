<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;

use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class AdminAppointmentsExport implements FromQuery, WithHeadings, WithMapping, WithTitle, WithStrictNullComparison
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
            trans('appointments/admin_lang.fields.user_id'),
            trans('appointments/admin_lang.fields.doctor_id'),
            trans('appointments/admin_lang.fields.created_by'),
            trans('appointments/admin_lang.fields.center_id'),
            trans('appointments/admin_lang.fields.start_at'),
            trans('appointments/admin_lang.fields.service_id'),
            trans('appointments/admin_lang.fields.price'),
            trans('appointments/admin_lang.fields.insurance_carrier_id'),
            trans('appointments/admin_lang.fields.price_with_insurance'),
            trans('appointments/admin_lang.fields.applicaterd_insurance'),
            trans('appointments/admin_lang.fields.total'),
            trans('appointments/admin_lang.fields.comment'),
            trans('appointments/admin_lang.fields.state'),
        ];
    }
    public function map($fila): array
    {
        return [
            !empty($fila->patient) ? $fila->patient->userProfile->fullName : null,
            !empty($fila->doctor) ? $fila->doctor->userProfile->fullName : null,
            !empty($fila->createdBy) ? $fila->createdBy->userProfile->fullName : null,
            !empty($fila->center) ? $fila->center->name : null,
            !empty($fila->start_at) ? Carbon::parse($fila->start_at)->format("d/m/Y H:i") : null,
            !empty($fila->service) ? $fila->service->name : null,
            !empty($fila->price) ? $fila->price : null,
            !empty($fila->insurance) ? $fila->insurance->name : null,
            $fila->price_with_insurance,
            $fila->applicaterd_insurance ?  trans('general/admin_lang.yes') : trans('general/admin_lang.no'),
            $fila->total,
            $fila->comment,
            ucfirst($fila->state),
        ];
    }

    public function title(): string
    {
        return trans('appointments/admin_lang.appointments');
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
