<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $guarded = array('id');

    public static $rules = array(
        'goods_id' => 'required',
        'edited_at' => 'required',
    );
}