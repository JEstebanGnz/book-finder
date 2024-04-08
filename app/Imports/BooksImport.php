<?php

namespace App\Imports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithUpserts;

class BooksImport implements ToModel, WithUpserts, WithHeadingRow
{

    public function model(array $row)
    {
        return new Book([
            'identifier' => str_replace('-', '', $row['isbn']),
            'title' => $row['titulo'],
            'price' => $row['precio'],
            'author' => $row['autor'],
            'publisher' => $row['editorial']
        ]);
    }

    public function uniqueBy()
    {
        return "identifier";
    }

    public function map($row): array
    {
        return [
            'identifier' => str_replace('-', '', $row['isbn']),
            // Other columns as needed
        ];
    }
}
