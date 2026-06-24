<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blueprint extends Model
{
    protected $fillable=
    ['name','tone','target_audience','max_characters','max_hashtags','user_id'];

    public function user(){
        return $this ->belongsTo(User::class);
    }

    //  public function posts()
    // {
    //     return $this->hasMany(Post::class);
    // }
}
