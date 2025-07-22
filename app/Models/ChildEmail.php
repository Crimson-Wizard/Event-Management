<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChildEmail extends Model
{
    protected $fillable = ['email', 'parent_email_id'];
}
