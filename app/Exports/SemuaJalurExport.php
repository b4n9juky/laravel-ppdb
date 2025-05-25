<?php

namespace App\Exports;

use App\Models\JalurPendaftaran;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SemuaJalurExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        $sheets = [];

        $jalurs = JalurPendaftaran::all();

        foreach ($jalurs as $jalur) {
            $sheets[] = new DataPerJalurSheetExport($jalur);
        }

        return $sheets;
    }
}
