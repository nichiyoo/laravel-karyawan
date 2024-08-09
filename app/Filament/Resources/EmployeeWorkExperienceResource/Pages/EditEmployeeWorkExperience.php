<?php

namespace App\Filament\Resources\EmployeeWorkExperienceResource\Pages;

use App\Filament\Resources\EmployeeWorkExperienceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeWorkExperience extends EditRecord
{
    protected static string $resource = EmployeeWorkExperienceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
