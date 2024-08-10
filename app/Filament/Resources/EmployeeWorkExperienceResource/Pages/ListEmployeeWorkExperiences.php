<?php

namespace App\Filament\Resources\EmployeeWorkExperienceResource\Pages;

use App\Filament\Exports\EmployeeWorkExperienceExporter;
use App\Filament\Resources\EmployeeWorkExperienceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeWorkExperiences extends ListRecords
{
    protected static string $resource = EmployeeWorkExperienceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\ExportAction::make()
                ->label('Export Data')
                ->exporter(EmployeeWorkExperienceExporter::class),
        ];
    }
}
