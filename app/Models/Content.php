<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $table = "content";
    public $timestamps = false;

    public function feadback(){
        return $this->belongsTo(Feedback::class,'Feedback','blog_unique_id');
    }
}
