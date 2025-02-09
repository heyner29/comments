<?php

namespace LaravelEnso\Comments\app\Policies;

use Carbon\Carbon;
use LaravelEnso\Core\app\Models\User;
use LaravelEnso\Comments\app\Models\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function before($user)
    {
        if ($user->isAdmin() || $user->isSupervisor()) {
            return true;
        }
    }

    public function update(User $user, Comment $comment)
    {
        return $this->ownsComment($user, $comment)
            && $this->isRecent($comment);
    }

    public function destroy(User $user, Comment $comment)
    {
        return $this->ownsComment($user, $comment)
            && $this->isRecent($comment);
    }

    private function ownsComment(User $user, Comment $comment)
    {
        return $user->id === (int) $comment->created_by;
    }

    private function isRecent(Comment $comment)
    {
        return $comment->created_at->diffInSeconds(Carbon::now())
            < config('enso.comments.editableTimeLimit');
    }
}
