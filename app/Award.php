<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    protected $appends = ['name_parts', 'grade_string'];

    public function getNamePartsAttribute() {
    	return explode('-', $this->name);
    }

    public function getGradeStringAttribute() {
    	return config('grades')[$this->grade];
    }

    public function scopeUserAndName($query, $userId, $name) {
    	return $query->where('user_id', $userId)->where('name', $name);
    }
}
