<?php

namespace App\Filament\Resources\EmployeeFamilyResource\Pages;

use App\Filament\Exports\EmployeeFamilyExporter;
use App\Filament\Resources\EmployeeFamilyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeFamilies extends ListRecords
{
    protected static string $resource = EmployeeFamilyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\ExportAction::make()
                ->label('Export Data')
                ->exporter(EmployeeFamilyExporter::class),
        ];
    }
}
