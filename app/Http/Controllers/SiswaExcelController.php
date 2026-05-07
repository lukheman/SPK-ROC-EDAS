<?php

namespace App\Http\Controllers;

use App\Exports\SiswaExport;
use App\Exports\SiswaTemplateExport;
use App\Imports\SiswaImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class SiswaExcelController extends Controller
{
    public function export()
    {
        return Excel::download(new SiswaExport, 'data-siswa.xlsx');
    }

    public function template()
    {
        return Excel::download(new SiswaTemplateExport, 'template-siswa.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ], [
            'file.required' => 'File Excel wajib diunggah.',
            'file.mimes'    => 'Format file harus xlsx, xls, atau csv.',
            'file.max'      => 'Ukuran file maksimal 10MB.',
        ]);

        try {
            $import = new SiswaImport;
            Excel::import($import, $request->file('file'));

            flash()->success("Berhasil mengimpor {$import->importedCount} data siswa!");
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $messages = [];
            foreach ($failures as $failure) {
                $messages[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }
            flash('Gagal import: ' . implode(' | ', $messages), 'danger');
        } catch (\Exception $e) {
            flash('Gagal import data: ' . $e->getMessage(), 'danger');
        }

        return redirect()->route('siswa-table');
    }
}
