<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ParentEmail extends Model
{
    protected $fillable = ['email'];

    public function childEmails() : HasMany {

        return $this->hasMany (ChildEmail::class);
    }
}

