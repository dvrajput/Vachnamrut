<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategoryLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_category_code',
        'user_id',
        'action',
        'changes',
        'ip_address',
    ];
}
