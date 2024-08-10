<?php

namespace App\Filament\Resources;

use App\Enums\BloodType;
use App\Enums\Education;
use App\Enums\Gender;
use App\Enums\MaritalStatus;
use App\Enums\Relation;
use App\Enums\Religion;
use App\Enums\TaxStatus;
use App\Filament\Exports\EmployeeExporter;
use App\Filament\Resources\EmployeeResource\Pages;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Wizard;
use Filament\Support;
use Filament\Tables\Actions\ExportAction;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;
    protected static ?string $navigationGroup = 'Karyawan';
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return __('Data Karyawan');
    }

    public static function form(Form $form): Form
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
                                        ->required(),

                                    Forms\Components\TextInput::make('ktp_number')
                                        ->label('Nomor Induk Kependudukan')
                                        ->validationAttribute('Nomor Induk Kependudukan')
                                        ->length(16)
                                        ->required(),

                                    Forms\Components\TextInput::make('name')
                                        ->label('Nama Lengkap')
                                        ->validationAttribute('Nama Lengkap')
                                        ->required(),

                                    Forms\Components\DatePicker::make('birthdate')
                                        ->label('Tanggal Lahir')
                                        ->validationAttribute('Tanggal Lahir')
                                        ->required(),

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
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Tanggal Diubah')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('nik')
                    ->label('Nomor Induk Pegawai')
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Lengkap')
                    ->searchable(),

                Tables\Columns\TextColumn::make('gender')
                    ->label('Jenis Kelamin')
                    ->badge(),

                Tables\Columns\TextColumn::make('birthdate')
                    ->label('Tanggal Lahir')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('birthplace')
                    ->label('Tempat Lahir')
                    ->searchable(),

                Tables\Columns\TextColumn::make('marital_status')
                    ->label('Status Pernikahan')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('religion')
                    ->label('Agama')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('blood_type')
                    ->label('Golongan Darah')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('tax_status')
                    ->label('Status Pajak')
                    ->badge(),

                Tables\Columns\TextColumn::make('npwp')
                    ->label('Nomor Pokok Wajib Pajak')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('bpjs_tenaga_kerja')
                    ->label('Nomor BPJS Tenaga Kerja')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('bpjs_kesehatan')
                    ->label('Nomor BPJS Kesehatan')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('phone_number')
                    ->label('Nomor Telepon')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('gender')
                    ->label('Jenis Kelamin')
                    ->options(Gender::class),

                Tables\Filters\SelectFilter::make('tax_status')
                    ->label('Status Pajak')
                    ->options(TaxStatus::class),

                Tables\Filters\SelectFilter::make('marital_status')
                    ->label('Status Pernikahan')
                    ->options(MaritalStatus::class),

                Tables\Filters\SelectFilter::make('religion')
                    ->label('Agama')
                    ->options(Religion::class),

                Tables\Filters\SelectFilter::make('blood_type')
                    ->label('Golongan Darah')
                    ->options(BloodType::class),

                Tables\Filters\SelectFilter::make('tax_status')
                    ->label('Status Pajak')
                    ->options(TaxStatus::class),
            ], layout: Tables\Enums\FiltersLayout::Modal)
            ->filtersFormWidth(Support\Enums\MaxWidth::TwoExtraLarge)
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'view' => Pages\ViewEmployee::route('/{record}'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
