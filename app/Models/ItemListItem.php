<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;
use App\Models\ItemList;

class ItemListItem extends Model
{
    use HasFactory;


    protected $fillable= [
        'item_id',
        'item_list_id'
    ];

    public function belongsToItemList() {
        return $this->belongsTo(ItemList::class);
    }

    public function belongsToItems() {
        return $this->belongsTo(Item::class);
    }
}
