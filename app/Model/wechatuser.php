<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class wechatuser extends Model
{
    protected $table = 'wechatuser';
    protected $pk = 'user_id';
    public $timestamps = false;
    protected $guarded = [];
}