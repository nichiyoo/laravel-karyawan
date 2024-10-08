<?php

namespace App\Livewire\Employee;

use App\Enums\Gender;
use App\Enums\Relation;
use App\Enums\MaritalStatus;
use App\Enums\TaxStatus;
use App\Enums\Education;
use App\Enums\Religion;
use App\Enums\BloodType;
use App\Models\Employee;
use Livewire\Component;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Forms\Components\Wizard;

class CreateEmployee extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public string $title = 'Buat Data Karyawan';

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Detail Data Karyawan')
                        ->schema([
                            Forms\Components\Section::make('Data Kartu Tanda Penduduk dan Karyawan')
                                ->description('Isi data dengan benar sesuai dokumen terkait.')
                                ->schema([
                                    Forms\Components\TextInput::make('nik')
                                        ->label('Nomor Induk Karyawan')
                                        ->validationAttribute('Nomor Induk Karyawan')
                                        ->required()
                                        ->unique(table: Employee::class),

                                    Forms\Components\TextInput::make('ktp_number')
                                        ->label('Nomor Induk Kependudukan')
                                        ->validationAttribute('Nomor Induk Kependudukan')
                                        ->length(16)
                                        ->required()
                                        ->unique(table: Employee::class),

                                    Forms\Components\TextInput::make('name')
                                        ->label('Nama Lengkap')
                                        ->validationAttribute('Nama Lengkap')
                                        ->required(),

                                    Forms\Components\DatePicker::make('birthdate')
                                        ->label('Tanggal Lahir')
                                        ->validationAttribute('Tanggal Lahir')
                                        ->required()
                                        ->before('today'),

                                    Forms\Components\TextInput::make('birthplace')
                                        ->label('Tempat Lahir')
                                        ->validationAttribute('Tempat Lahir')
                                        ->required(),

                                    Forms\Components\ToggleButtons::make('gender')
                                        ->label('Jenis Kelamin')
                                        ->validationAttribute('Jenis Kelamin')
                                        ->options(Gender::class)
                                        ->inline()
                                        ->required(),

                                    Forms\Components\Select::make('religion')
                                        ->label('Agama')
                                        ->validationAttribute('Agama')
                                        ->options(Religion::class)
                                        ->required(),

                                    Forms\Components\ToggleButtons::make('blood_type')
                                        ->label('Golongan Darah')
                                        ->validationAttribute('Golongan Darah')
                                        ->options(BloodType::class)
                                        ->inline()
                                        ->required(),

                                    Forms\Components\TextInput::make('ktp_zipcode')
                                        ->label('Kode Pos')
                                        ->validationAttribute('Kode Pos')
                                        ->required(),

                                    Forms\Components\Textarea::make('ktp_address')
                                        ->label('Alamat KTP')
                                        ->validationAttribute('Alamat KTP')
                                        ->required()
                                        ->columnSpan('full'),
                                ])
                                ->collapsible()
                                ->columns(2),

                            Forms\Components\Section::make('Data Pendidikan Terakhir')
                                ->description('Isi data dengan benar sesuai dokumen terkait.')
                                ->schema([
                                    Forms\Components\ToggleButtons::make('last_education')
                                        ->label('Jenis Pendidikan')
                                        ->validationAttribute('Jenis Pendidikan')
                                        ->options(Education::class)
                                        ->inline()
                                        ->required(),

                                    Forms\Components\TextInput::make('almamater')
                                        ->label('Nama Universitas / Nama Sekolah')
                                        ->validationAttribute('Nama Universitas / Nama Sekolah')
                                        ->required(),

                                    Forms\Components\TextInput::make('last_education_major')
                                        ->label('Nama Jurusan')
                                        ->validationAttribute('Nama Jurusan')
                                        ->required(),
                                ])
                                ->collapsible()
                                ->columns(2),

                            Forms\Components\Section::make('Data Pernikahan')
                                ->description('Isi data dengan benar sesuai dokumen terkait.')
                                ->schema([
                                    Forms\Components\Select::make('marital_status')
                                        ->label('Status Pernikahan')
                                        ->validationAttribute('Status Pernikahan')
                                        ->options(MaritalStatus::class)
                                        ->required()
                                        ->live(),

                                    Forms\Components\DatePicker::make('marriage_date')
                                        ->label('Tanggal Pernikahan')
                                        ->validationAttribute('Tanggal Pernikahan')
                                        ->required(fn(Get $get): bool => $get('marital_status') == MaritalStatus::NIKAH->value)
                                        ->hidden(fn(Get $get): bool => !$get('marital_status') || $get('marital_status') != MaritalStatus::NIKAH->value),

                                    Forms\Components\TextInput::make('children_count')
                                        ->label('Jumlah Anak')
                                        ->validationAttribute('Jumlah Anak')
                                        ->numeric()
                                        ->minValue(0)
                                        ->hidden(fn(Get $get): bool => !$get('marital_status') || $get('marital_status') == MaritalStatus::LAJANG->value)
                                        ->live(),
                                ])
                                ->collapsible()
                                ->columns(2),

                            Forms\Components\Section::make('Data Pajak dan Asuransi')
                                ->description('Isi data dengan benar sesuai dokumen terkait.')
                                ->schema([
                                    Forms\Components\Select::make('tax_status')
                                        ->label('Status Pajak')
                                        ->validationAttribute('Status Pajak')
                                        ->options(TaxStatus::class)
                                        ->required(),

                                    Forms\Components\TextInput::make('npwp')
                                        ->label('Nomor Pokok Wajib Pajak')
                                        ->validationAttribute('Nomor Pokok Wajib Pajak')
                                        ->required(),

                                    Forms\Components\TextInput::make('bpjs_tenaga_kerja')
                                        ->label('Nomor BPJS Tenaga Kerja')
                                        ->validationAttribute('Nomor BPJS Tenaga Kerja')
                                        ->required(),

                                    Forms\Components\TextInput::make('bpjs_kesehatan')
                                        ->label('Nomor BPJS Kesehatan')
                                        ->validationAttribute('Nomor BPJS Kesehatan')
                                        ->required(),
                                ])
                                ->collapsible()
                                ->columns(2),

                            Forms\Components\Section::make('Data Kontak Karyawan')
                                ->description('Isi data dengan benar sesuai dokumen terkait.')
                                ->schema([
                                    Forms\Components\Textarea::make('current_address')
                                        ->label('Alamat Saat Ini')
                                        ->validationAttribute('Alamat Saat Ini')
                                        ->required()
                                        ->columnSpan('full'),

                                    Forms\Components\TextInput::make('phone_number')
                                        ->label('Nomor Telepon')
                                        ->validationAttribute('Nomor Telepon')
                                        ->prefix('+62')
                                        ->tel()
                                        ->required(),

                                    Forms\Components\TextInput::make('emergency_contact_number')
                                        ->label('Nomor Kontak Darurat')
                                        ->validationAttribute('Nomor Kontak Darurat')
                                        ->prefix('+62')
                                        ->tel()
                                        ->required(),
                                ])
                                ->collapsible()
                                ->columns(2),
                        ]),

                    Wizard\Step::make('Detail Data Keluarga')
                        ->schema([
                            Forms\Components\Repeater::make('families')
                                ->label('Data Keluarga')
                                ->relationship()
                                ->schema([
                                    Forms\Components\Select::make('relation')
                                        ->label('Jenis Hubungan')
                                        ->validationAttribute('Jenis Hubungan')
                                        ->options(Relation::class)
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
                                ->itemLabel(fn(array $state): ?string => $state['relation'] ?? 'Pilih Jenis Hubungan')
                                ->columns(2),
                        ]),

                    Wizard\Step::make('Data Riwayat Pekerjaan')
                        ->schema([
                            Forms\Components\Repeater::make('experiences')
                                ->label('Data Riwayat Pekerjaan')
                                ->relationship()
                                ->schema([
                                    Forms\Components\TextInput::make('company_name')
                                        ->label('Nama Perusahaan')
                                        ->required(),

                                    Forms\Components\TextInput::make('position')
                                        ->label('Jabatan')
                                        ->required(),

                                    Forms\Components\DatePicker::make('start_date')
                                        ->label('Tanggal Mulai Bekerja')
                                        ->required(),

                                    Forms\Components\DatePicker::make('end_date')
                                        ->label('Tanggal Berakhir Bekerja'),
                                ])
                                ->itemLabel(fn(array $state): ?string => $state['company_name'] ?? 'Nama Perusahaan')
                                ->columns(2),
                        ]),

                    Wizard\Step::make('Unggah Berkas Karyawan')
                        ->schema([
                            Forms\Components\Section::make('Unggah File')
                                ->description('Isi data dengan benar sesuai dokumen terkait.')
                                ->schema([
                                    Forms\Components\FileUpload::make('file_kk')
                                        ->label('File Kartu Keluarga')
                                        ->validationAttribute('File Kartu Keluarga')
                                        ->image()
                                        ->imageEditor()
                                        ->required(),

                                    Forms\Components\FileUpload::make('file_ktp')
                                        ->label('File Kartu Tanda Penduduk')
                                        ->validationAttribute('File Kartu Tanda Penduduk')
                                        ->image()
                                        ->imageEditor()
                                        ->required(),

                                    Forms\Components\FileUpload::make('file_npwp')
                                        ->label('File Nomor Pokok Wajib Pajak')
                                        ->validationAttribute('File Nomor Pokok Wajib Pajak')
                                        ->image()
                                        ->imageEditor()
                                        ->required(),

                                    Forms\Components\FileUpload::make('file_ijazah')
                                        ->label('File Ijazah Pendidikan Terakhir')
                                        ->validationAttribute('File Ijazah Pendidikan Terakhir')
                                        ->image()
                                        ->imageEditor()
                                        ->required(),

                                    Forms\Components\FileUpload::make('file_akta_nikah')
                                        ->label('File Akta Nikah')
                                        ->validationAttribute('File Akta Nikah')
                                        ->hidden(fn(Get $get): bool => $get('marital_status') != MaritalStatus::NIKAH->value)
                                        ->required(fn(Get $get): bool => $get('marital_status') == MaritalStatus::NIKAH->value)
                                        ->image()
                                        ->imageEditor(),

                                    Forms\Components\FileUpload::make('file_bpjs_kesehatan')
                                        ->label('File BPJS Kesehatan')
                                        ->validationAttribute('File BPJS Kesehatan')
                                        ->image()
                                        ->imageEditor()
                                        ->required(),

                                    Forms\Components\FileUpload::make('file_bpjs_tenaga_kerja')
                                        ->label('File BPJS Tenaga Kerja')
                                        ->validationAttribute('File BPJS Tenaga Kerja')
                                        ->image()
                                        ->imageEditor()
                                        ->required(),
                                ])
                                ->collapsible()
                                ->columns(2),
                        ]),
                ]),
            ])
            ->columns(1)
            ->statePath('data')
            ->model(Employee::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();
        $record = Employee::create($data);
        $this->form->model($record)->saveRelationships();
        $this->dispatch('open-modal', id: 'success-modal');
    }

    public function render()
    {
        return view('livewire.employee.create-employee');
    }
}
