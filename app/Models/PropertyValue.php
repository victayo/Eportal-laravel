<?php

namespace Eportal\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyValue extends Model
{
    protected $fillable = ['name', 'property_id'];

//    public static function getCollection($stdObjs){
//        $colClasses = $classes->map(function($class){
//            $pv = new PropertyValue();
//            $pv->fill((array)$class);
//            return $pv;
//        });
//        return collect($colClasses);
//    }

    public function property(){
        return $this->belongsTo(Property::class);
    }

}
