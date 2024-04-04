<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

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

}
