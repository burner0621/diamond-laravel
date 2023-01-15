<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Message extends Model
{
    protected $guarded = [];

    protected $fillable = [
        "user_id",
        "conversation_id",
        "message",
        "is_seen"
    ];

    public function seenAll($userId, $conversationId)
    {
        return $this->whereUserId($userId)->whereConversationId($conversationId)->update(["is_seen" => 1]);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function conversation()
    {
        return $this->belongsTo(User::class, 'conversation_id');
    }

    public function getAll($id)
    {
        return $this->whereUserId($id)->get();
    }

    public function getChatMessageOfUserLogin()
    {
        if (auth()->check()) {
            $userId = auth()->user()->id;
            $query = '
            SELECT   c.user_id , max(cnt) as cnt from (
            SELECT a.user_id,b.cnt FROM
                        (SELECT `user_id` FROM `messages` WHERE `conversation_id` = ' . $userId . ' and user_id != ' . $userId . '
            GROUP BY (user_id))as a
                        LEFT JOIN
                        (SELECT `user_id`, COUNT(*)
                        as cnt FROM `messages` WHERE `conversation_id` = ' . $userId . ' and user_id != ' . $userId . '

                         and is_seen=0  GROUP BY (user_id)
                        )as b
                        on a.user_id = b.user_id
                    UNION ALL
                    SELECT `conversation_id` as user_id,"0" as cnt FROM `messages` WHERE `user_id` = ' . $userId . '
                     and conversation_id!= ' . $userId . ' GROUP By `conversation_id`
                     )as c GROUP BY c.user_id
        ';
            return DB::select(DB::raw($query));
        }

        return [];
    }
}
