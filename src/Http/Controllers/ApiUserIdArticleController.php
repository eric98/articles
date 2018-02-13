<?php

namespace Ergare17\Articles\Http\Controllers;

use Ergare17\Articles\Http\Requests\UpdateUserIdArticle;
use Ergare17\Articles\Models\Article;

class ApiUserIdArticleController extends Controller
{
    public function update(UpdateUserIdArticle $request, Article $task)
    {
        $request->validate([
            'user_id' => 'required',
        ]);
        $task->user_id = $request->user_id;
        $task->save();

        return $task;
    }
}
