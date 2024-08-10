<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeWorkExperienceResource\Pages;
use App\Filament\Resources\EmployeeWorkExperienceResource\RelationManagers;
use App\Models\EmployeeWorkExperience;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeWorkExperienceResource extends Resource
{
    protected static ?string $model = EmployeeWorkExperience::class;
    protected static ?string $navigationGroup = 'Karyawan';
    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return __('Data Riwayat Pekerjaan');
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

                Forms\Components\TextInput::make('company_name')
                    ->label('Nama Perusahaan')
                    ->required()
                    ->columnSpan('full'),

                Forms\Components\TextInput::make('position')
                    ->label('Jabatan')
                    ->required(),

                Forms\Components\DatePicker::make('start_date')
                    ->label('Tanggal Mulai Bekerja')
                    ->required(),

                Forms\Components\DatePicker::make('end_date')
                    ->label('Tanggal Berakhir Bekerja'),
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

                Tables\Columns\TextColumn::make('company_name')
                    ->label('Nama Perusahaan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('position')
                    ->label('Jabatan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('start_date')
                    ->date('F j, Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('end_date')
                    ->date('F j, Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('employee.name'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('employee_id')
                    ->label('Nama Karyawan')
                    ->relationship('employee', 'name')
                    ->searchable()
                    ->preload()
            ])
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
            'index' => Pages\ListEmployeeWorkExperiences::route('/'),
            'create' => Pages\CreateEmployeeWorkExperience::route('/create'),
            'view' => Pages\ViewEmployeeWorkExperience::route('/{record}'),
            'edit' => Pages\EditEmployeeWorkExperience::route('/{record}/edit'),
        ];
    }
}
