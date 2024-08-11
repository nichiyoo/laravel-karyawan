<?php

namespace App\Livewire\EmployeeFamily;

use App\Enums\Gender;
use App\Enums\Relation;

use App\Models\EmployeeFamily;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class CreateEmployeeFamily extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public string $title = 'Buat Data Keluarga Karyawan';

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('employee_id')
                    ->label('Nama Karyawan')
                    ->relationship('employee', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('relation')
                    ->label('Jenis Hubungan')
                    ->validationAttribute('Jenis Hubungan')
                    ->options(Relation::class)
                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                    ->required()
                    ->live(),

                Forms\Components\TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->validationAttribute('Nama Lengkap')
                    ->required(),

                Forms\Components\DatePicker::make('birthdate')
                    ->label('Tanggal Lahir')
                    ->validationAttribute('Tanggal Lahir')
                    ->required(),

                Forms\Components\ToggleButtons::make('gender')
                    ->label('Jenis Kelamin')
                    ->validationAttribute('Jenis Kelamin')
                    ->options(Gender::class)
                    ->inline()
                    ->required(),

                Forms\Components\TextInput::make('bpjs_kesehatan')
                    ->label('Nomor BPJS Kesehatan')
                    ->validationAttribute('Nomor BPJS Kesehatan')
                    ->columnSpan('full'),

                Forms\Components\FileUpload::make('file_bpjs_kesehatan')
                    ->label('File BPJS Kesehatan')
                    ->validationAttribute('File BPJS Kesehatan')
                    ->image()
                    ->imageEditor()
                    ->columnSpan('full'),
            ])
            ->statePath('data')
            ->model(EmployeeFamily::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();
        $record = EmployeeFamily::create($data);
        $this->form->model($record)->saveRelationships();
        $this->dispatch('open-modal', id: 'success-modal');
    }

    public function render(): View
    {
        return view('livewire.employee-family.create-employee-family');
    }
}
