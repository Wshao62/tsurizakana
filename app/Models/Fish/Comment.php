<?php

namespace App\Models\Fish;

use App\Models\Fish;
use App\Notifications\CommentNotification;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Comment extends Model
{
    protected $fillable = [
        'fish_id',
        'user_id',
        'content'
    ];

    protected $table = 'fish_comments';

    const UPDATED_AT = null;

    /**
     *
     * save users comment
     *
     */
    public function saveComment(int $fish_id, string $comment)
    {
        try {
            $this->fish_id = $fish_id;
            $this->user_id = Auth::id();
            $this->content = $comment;
            $this->save();

            //メッセージ送信処理
            if (Fish::find($fish_id)->seller->id !== Auth::id()) {
                Fish::find($fish_id)->seller->notify(new CommentNotification($this));
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id')->orderBy('created_at', 'desc');
    }
}
