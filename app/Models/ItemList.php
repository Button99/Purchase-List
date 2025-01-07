<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Item;

class ItemList extends Model
{
    use HasFactory;

    protected $fillable= [
        'name',
        'tag',
        'public',
        'user_id',
        'created_at',
        'updated_at'
    ];

    public function items() {
        return $this->belongsToMany(Item::class, 'item_list_items');
    }

    public function belongsToUser() {
        return $this->belongsTo(User::class);
    }

}
