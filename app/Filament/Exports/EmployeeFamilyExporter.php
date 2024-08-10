<?php

namespace App\Filament\Exports;

use App\Models\EmployeeFamily;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class EmployeeFamilyExporter extends Exporter
{
    protected static ?string $model = EmployeeFamily::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')->label('ID'),
            ExportColumn::make('created_at')->label('Tanggal Dibuat'),
            ExportColumn::make('updated_at')->label('Tanggal Diubah'),
            ExportColumn::make('name')->label('Nama Lengkap'),
            ExportColumn::make('birthdate')->label('Tanggal Lahir'),
            ExportColumn::make('gender')->label('Jenis Kelamin')->getStateUsing(fn(EmployeeFamily $record) => $record->gender->getLabel()),
            ExportColumn::make('relation')->label('Peranan Pernikahan')->getStateUsing(fn(EmployeeFamily $record) => $record->relation->getLabel()),
            ExportColumn::make('bpjs_kesehatan')->label('Nomor BPJS Kesehatan'),
            ExportColumn::make('file_bpjs_kesehatan')->label('File BPJS Kesehatan'),
            ExportColumn::make('employee.name')->label('Nama Karyawan'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Export data keluarga karyawan anda telah selesai dan ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' telah diexport.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' gagal diexport.';
        }

        return $body;
    }
}
