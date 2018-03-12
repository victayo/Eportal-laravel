<?php

namespace Eportal\Models;

use Illuminate\Database\Eloquent\Model;

class RelPropertyValue extends Model
{
    protected $fillable = ['property_value', 'parent'];
}
