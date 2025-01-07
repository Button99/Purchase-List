<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ItemList;
use App\Models\ItemPicture;


class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'link',
        'has_been_bought',
        'item_list_id'
    ];

    public function lists() {
        return $this->belongsToMany(ItemList::class, 'item_list_items');
    }

    public function picture() {
        return $this->hasOne(ItemPicture::class);
    }
}
