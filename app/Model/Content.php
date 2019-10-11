<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $table ='content';
    protected $pk='id';
    public $timestamps = false;
}
