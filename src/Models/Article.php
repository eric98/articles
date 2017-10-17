<?php

namespace Ergare17\Articles\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ["title", "description", "updated_at", "created_at"];
}
