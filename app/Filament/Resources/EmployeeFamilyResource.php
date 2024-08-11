<?php

namespace App\Filament\Resources;

use App\Enums\Gender;
use App\Enums\Relation;
use App\Filament\Resources\EmployeeFamilyResource\Pages;
use App\Filament\Resources\EmployeeFamilyResource\RelationManagers;
use App\Models\EmployeeFamily;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeFamilyResource extends Resource
{
    protected static ?string $model = EmployeeFamily::class;
    protected static ?string $navigationGroup = 'Karyawan';
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?int $navigationSort = 3;

    public static function getModelLabel(): string
    {
        return __('Data Keluarga Karyawan');
    }

    public static function form(Form $form): Form
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Lengkap')
                    ->searchable(),

                Tables\Columns\TextColumn::make('gender')
                    ->label('Jenis Kelamin')
                    ->badge(),

                Tables\Columns\TextColumn::make('birthdate')
                    ->label('Tanggal Lahir')
                    ->date('F j, Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('relation')
                    ->label('Jenis Hubungan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('bpjs_kesehatan')
                    ->label('Nomor BPJS Kesehatan')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\ImageColumn::make('file_bpjs_kesehatan')
                    ->label('File BPJS Kesehatan')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('employee.name')
                    ->label('Nama Karyawan'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('gender')
                    ->label('Jenis Kelamin')
                    ->options(Gender::class),

                Tables\Filters\SelectFilter::make('relation')
                    ->label('Jenis Hubungan')
                    ->options(Relation::class),

                Tables\Filters\SelectFilter::make('employee_id')
                    ->label('Nama Karyawan')
                    ->relationship('employee', 'name')
                    ->searchable()
                    ->preload()
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListEmployeeFamilies::route('/'),
            'create' => Pages\CreateEmployeeFamily::route('/create'),
            'view' => Pages\ViewEmployeeFamily::route('/{record}'),
            'edit' => Pages\EditEmployeeFamily::route('/{record}/edit'),
        ];
    }
}
