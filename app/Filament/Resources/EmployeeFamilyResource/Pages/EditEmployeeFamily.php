<?php

namespace App\Filament\Resources\EmployeeFamilyResource\Pages;

use App\Filament\Resources\EmployeeFamilyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeFamily extends EditRecord
{
    protected static string $resource = EmployeeFamilyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
