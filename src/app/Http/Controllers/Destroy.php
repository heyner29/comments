<?php

namespace LaravelEnso\Comments\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Comments\app\Models\Comment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Destroy extends Controller
{
    use AuthorizesRequests;

    public function __invoke(Comment $comment)
    {
        $this->authorize('destroy', $comment);

        $comment->delete();

        return ['count' => $comment->commentable->comments()->count()];
    }
}
