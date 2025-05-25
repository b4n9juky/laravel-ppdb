<?php

namespace App\Exports;

use App\Models\Pendaftars;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class DataExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Pendaftars::where('status', 'diterima')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,

                    'nisn' => $item->nisn,
                    'nomor' => $item->nomor_pendaftaran,
                    'nama' => $item->nama_lengkap,
                    'jenis_kelamin' => $item->jenis_kelamin,
                    'tempat_lahir' => $item->tempat_lahir,
                    'tanggal_lahir' => $item->tanggal_lahir,
                    'sekolah_asal' => $item->sekolah_asal,
                    'alamat' => $item->alamat,
                    'no_telp' => $item->no_hp,
                    'jalur' => $item->jalur->nama_jalur ?? '-',
                    'status' => $item->status,
                ];
            });
    }
    public function headings(): array
    {
        return [
            'ID',
            'NISN',
            'Nomor Pendaftaran',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Sekolah Asal',
            'Alamat',
            'Nomer HP',
            'Jalur Pendaftaran',
            'Status',


        ];
    }
}
