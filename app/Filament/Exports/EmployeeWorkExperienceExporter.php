<?php

namespace App\Filament\Exports;

use App\Models\EmployeeWorkExperience;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class EmployeeWorkExperienceExporter extends Exporter
{
    protected static ?string $model = EmployeeWorkExperience::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')->label('ID'),
            ExportColumn::make('created_at')->label('Tanggal Dibuat'),
            ExportColumn::make('updated_at')->label('Tanggal Diubah'),
            ExportColumn::make('company_name')->label('Nama Perusahaan'),
            ExportColumn::make('position')->label('Jabatan'),
            ExportColumn::make('start_date')->label('Tanggal Mulai'),
            ExportColumn::make('end_date')->label('Tanggal Selesai'),
            ExportColumn::make('employee.name')->label('Nama Karyawan'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Export data riwayat kerja karyawan anda telah selesai dan ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' telah diexport.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' gagal diexport.';
        }

        return $body;
    }
}
