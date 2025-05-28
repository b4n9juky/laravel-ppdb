<?php

namespace App\Exports;

use App\Models\Pendaftars;
use App\Models\JalurPendaftaran;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DataPerJalurSheetExport implements FromCollection, WithTitle, WithHeadings
{
    protected $jalur;

    public function __construct(JalurPendaftaran $jalur)
    {
        $this->jalur = $jalur;
    }

    public function collection()
    {

        return Pendaftars::with('jalur', 'nilaiPendaftar')
            ->withSum('nilaiPendaftar as total_nilai', 'nilai')
            ->where('status', 'diterima')
            ->where('jalur_pendaftaran_id', $this->jalur->id)
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
                    'total_nilai' => $item->total_nilai, // ini otomatis hasil SUM dari relasi
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
            'Total Nilai',
        ];
    }

    public function title(): string
    {
        return $this->jalur->nama_jalur; // pastikan field ini ada
    }
}
