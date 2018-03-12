<?php

namespace Eportal\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = ['name'];

    public function propertyValues(){
        return $this->hasMany(PropertyValue::class);
    }
}
