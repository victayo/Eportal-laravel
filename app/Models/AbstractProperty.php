<?php

namespace Eportal\Models;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractProperty extends Model
{
    protected $fillable = ['name'];
    
    public function getId(){
        return $this->id;
    }
    
    public function getName(){
        return $this->name;
    }
    
    public function setName($name){
        $this->name = $name;
        return $this;
    }
}
