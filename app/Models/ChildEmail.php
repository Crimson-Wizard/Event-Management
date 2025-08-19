<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChildEmail extends Model
{
    protected $fillable = ['email', 'parent_email_id'];

    public function parentEmail(): BelongsTo
    {
        return $this->belongsTo(ParentEmail::class);
    }
}
