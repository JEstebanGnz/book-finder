<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Ods;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Book extends Model
{
    use HasFactory;

    protected $fillable = ['identifier', 'title', 'author', 'price', 'publisher'];

    public function search($searchTerm)
    {
        return $this->where(function ($query) use ($searchTerm) {
            // Iterate through all table columns and add where clauses
            foreach (Schema::getColumnListing($this->getTable()) as $column) {
                $query->orWhere($column, 'like', '%' . $searchTerm . '%');
            }
        })->get();
    }

    public static function convertOdsToXlsx($odsFilePath)
    {
        // Load .ods file using PhpSpreadsheet
        $spreadsheet = IOFactory::load($odsFilePath);


        dd($spreadsheet);

        // Create a temporary file path for .xlsx
        $xlsxFilePath = tempnam(sys_get_temp_dir(), 'excel');

        // Write .xlsx file
        $writer = new Xlsx($spreadsheet);
        $writer->save($xlsxFilePath);

        return $xlsxFilePath;
    }

}
