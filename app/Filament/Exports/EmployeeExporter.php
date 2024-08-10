<?php

namespace App\Filament\Exports;

use App\Models\Employee;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class EmployeeExporter extends Exporter
{
    protected static ?string $model = Employee::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')->label('ID'),
            ExportColumn::make('created_at')->label('Tanggal Dibuat'),
            ExportColumn::make('updated_at')->label('Tanggal Diubah'),
            ExportColumn::make('nik')->label('Nomor Induk Karyawan'),
            ExportColumn::make('name')->label('Nama Lengkap'),
            ExportColumn::make('birthdate')->label('Tanggal Lahir'),
            ExportColumn::make('birthplace')->label('Tempat Lahir'),
            ExportColumn::make('gender')->label('Jenis Kelamin')->getStateUsing(fn(Employee $record) => $record->gender->getLabel()),
            ExportColumn::make('ktp_number')->label('Nomor Induk Kependudukan'),
            ExportColumn::make('ktp_address')->label('Alamat KTP'),
            ExportColumn::make('ktp_zipcode')->label('Kode Pos'),
            ExportColumn::make('last_education')->label('Jenis Pendidikan')->getStateUsing(fn(Employee $record) => $record->last_education->getLabel()),
            ExportColumn::make('last_education_major')->label('Nama Jurusan'),
            ExportColumn::make('almamater')->label('Nama Universitas / Sekolah'),
            ExportColumn::make('religion')->label('Agama')->getStateUsing(fn(Employee $record) => $record->religion->getLabel()),
            ExportColumn::make('blood_type')->label('Golongan Darah')->getStateUsing(fn(Employee $record) => $record->blood_type->getLabel()),
            ExportColumn::make('marital_status')->label('Status Pernikahan')->getStateUsing(fn(Employee $record) => $record->marital_status->getLabel()),
            ExportColumn::make('marriage_date')->label('Tanggal Pernikahan'),
            ExportColumn::make('children_count')->label('Jumlah Anak'),
            ExportColumn::make('tax_status')->label('Status Pajak')->getStateUsing(fn(Employee $record) => $record->tax_status->getLabel()),
            ExportColumn::make('npwp')->label('Nomor Pokok Wajib Pajak'),
            ExportColumn::make('bpjs_tenaga_kerja')->label('Nomor BPJS Tenaga Kerja'),
            ExportColumn::make('bpjs_kesehatan')->label('Nomor BPJS Kesehatan'),
            ExportColumn::make('current_address')->label('Alamat Saat Ini'),
            ExportColumn::make('phone_number')->label('Nomor Telepon'),
            ExportColumn::make('emergency_contact_number')->label('Nomor Kontak Darurat'),
            ExportColumn::make('created_at')->label('Tanggal Dibuat'),
            ExportColumn::make('file_kk')->label('File Kartu Keluarga'),
            ExportColumn::make('file_ktp')->label('File Kartu Tanda Penduduk'),
            ExportColumn::make('file_npwp')->label('File Nomor Pokok Wajib Pajak'),
            ExportColumn::make('file_ijazah')->label('File Ijazah Pendidikan Terakhir'),
            ExportColumn::make('file_akta_nikah')->label('File Akta Nikah'),
            ExportColumn::make('file_bpjs_kesehatan')->label('File BPJS Kesehatan'),
            ExportColumn::make('file_bpjs_tenaga_kerja')->label('File BPJS Tenaga Kerja'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Export data karyawan anda telah selesai dan ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' telah diexport.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' gagal diexport.';
        }

        return $body;
    }
}
