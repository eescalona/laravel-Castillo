<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    public $table = 'styles';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function project(){
        return $this->hasMany(Project::class);
    }
}
