<?php

namespace Ergare17\Articles\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'description', 'user_id', 'completed'];

    public function toArray()
    {
        return [
            'id'          => $this->id,
            'title'        => $this->title,
            'description' => $this->description,
            'user_id'     => $this->user_id,
            'read'   => $this->read ? true : false,
            'created_at'  => $this->created_at.'',
            'updated_at'  => $this->updated_at.'',
        ];
    }
}
