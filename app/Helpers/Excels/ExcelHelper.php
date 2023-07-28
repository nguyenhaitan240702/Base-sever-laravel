<?php

namespace App\Helpers\Excels;

use App\Helpers\Excels\Exports\BaseExport;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExcelHelper
{
    public function __construct()
    {
        //
    }
    public function import($import, $file): bool
    {
        try {
            DB::beginTransaction();
            Excel::import($import,$file);
            // you can customize for your project
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }
    public function export($collection, $nameFile): BinaryFileResponse
    {
        // you can customize for your project
        return Excel::download(new BaseExport($collection), $nameFile);
    }
}
