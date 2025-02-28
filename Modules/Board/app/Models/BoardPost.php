<?php

declare(strict_types=1);

namespace Modules\Board\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Modules\Board\Database\Factories\BoardPostFactory;

class BoardPost extends Model
{
    use HasFactory;

    protected $table = 'board_posts';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'title',
        'contents',
        'status',
    ];

    // protected static function newFactory(): BoardPostFactory
    // {
    //     // return BoardPostFactory::new();
    // }
}
