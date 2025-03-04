<?php

declare(strict_types=1);

namespace Modules\Board\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use Modules\Board\Database\Factories\BoardAttachmentFactory;

class BoardAttachment extends Model
{
    use HasFactory;

    protected $table = 'board__attachments';

    /**
     * The attributes that are mass assignable.
     */
    const UPDATED_AT = null;

    protected $fillable = [
        'file_path',
        'file_name',
        'post_id',
    ];

    // protected static function newFactory(): BoardAttachmentFactory
    // {
    //     // return BoardAttachmentFactory::new();
    // }
}
