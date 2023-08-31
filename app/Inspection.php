<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inspection extends Model
{
    //
    use SoftDeletes;
    protected $table = 'inspection';
    protected $primaryKey = 'inspection_id';

    protected $fillable = [
        'inspection_id', 'hive_date', 'normal_hive_condition', 'saw_queen', 'created_at', 'updated_at', 'deleted_at'
    ];
    
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
