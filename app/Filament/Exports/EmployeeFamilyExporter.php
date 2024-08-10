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
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
            ExportColumn::make('name'),
            ExportColumn::make('birthdate'),
            ExportColumn::make('gender'),
            ExportColumn::make('relation'),
            ExportColumn::make('bpjs_kesehatan'),
            ExportColumn::make('file_bpjs_kesehatan'),
            ExportColumn::make('employee.name'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your employee family export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
