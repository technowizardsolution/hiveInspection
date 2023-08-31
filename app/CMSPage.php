<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CMSPage extends Model
{
    use SoftDeletes;
    protected $table = 'cms_pages';
    protected $primaryKey = 'cms_page_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'page_title','slug','content','metaDescription','metaKeyword', 'status'
    ];

    
}
	