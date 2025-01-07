<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;

class ItemPicture extends Model
{
    use HasFactory;

    protected $fillable= [
        'path',
        'ext',
        'created_at',
        'updated_at',
        'item_id'
    ];

    public function item() {
        return $this->belongsTo(Item::class);
    }
}
