<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hive extends Model
{
    //
    use SoftDeletes;
    protected $table = 'hive';
    protected $primaryKey = 'hive_id';

    protected $fillable = [
        'hive_id', 'hive_name', 'location', 'build_date', 'created_at', 'updated_at', 'deleted_at'
    ];
    
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
