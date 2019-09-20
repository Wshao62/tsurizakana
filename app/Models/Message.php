<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Validation\Rule;
use App\Models\Message\Photo;
use App\Models\User;
use App\Models\Fish;
use App\Models\UserPhoto;
use App\Helpers\FileHelper;
use App\Models\Traits\Register;
use Illuminate\Notifications\Notifiable;
use App\Notifications\NotifyMessage;
use Carbon\Carbon;

class Message extends Model
{
    use Register;
    use Notifiable;

    /**
     * Fields that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'fish_id',
        'user_id',
        'receiver_id',
        'img_url',
        'message',
        'is_seen'
    ];


    const UNREAD = 0;
    const READ = 1;
    const SENDMAIL = 2;

    public static function fish($fish_id){
        return Fish::whereId($fish_id)->first();
    }

    public function notifications()
    {
        return self::select(['receiver_id', 'fish_id'])->whereIsSeen(self::UNREAD)
                    ->where('is_seen', '!=', self::SENDMAIL)
                    ->where('created_at', '<', Carbon::now()->subHours(1)->toDateTimeString())
                    ->groupBy('fish_id', 'receiver_id')
                    ->get();
    }

    /**
     * Get User Record
     *
     * @param  int $user_id
     *
     */
    public static function msgUser($user_id)
    {
       $name =  User::find($user_id);
       $photo = UserPhoto::where('user_id',$user_id)->first();

       $user = [
            'name' => $name->name,
            'photo' => $photo == null ? "" : $photo->profile_photo
       ];

       return $user;
    }

    /**
     * Get last {$take} messages with all other users.
     *
     * @param  int  $fish_id
     * @param  int  $take  (optional)
     * @return collection
     */
    public static function mssgFetch($fish_id, $take = 10)
    {
        $conversations = self::msgConversations($fish_id, $take);
        $threads = [];
        foreach ($conversations as $key => $conversation) {
            $collection              = (object) null;
            $collection->user        = self::msgUser($conversation->user_id);
            $collection->fish_id     = $conversation->fish_id;
            $collection->user_id     = $conversation->user_id;
            $collection->message     = preg_replace('/\A[\x00\s]++|[\x00\s]++\z/u', '', htmlspecialchars_decode($conversation->message));
            $collection->img_url     = $conversation->img_url;
            $collection->created_at  = $conversation->created_at;
            $threads[]               = $collection;
        }
        $threads = collect($threads);
        $threads = $threads->sortByDesc(function ($ins, $key) {
            $ins = (array) $ins;
            return $ins['created_at'];
        });
        return json_decode($threads, true);
    }
    /**
     * Make messages seen for a conversation.
     *
     * @param  int  $fish_id
     * @param  int  $user_id
     * @return boolean
     */
    public static function msgSeen($fish_id)
    {
        Message::whereFishId($fish_id)->update([
            'is_seen' => self::READ
        ]);

        return response()->json(['success' => true], 200);
    }

    /**
     * Mark as read all message
     *
     * @return boolean
     */
    public static function msgMark($user_id)
    {
        Message::whereReceiverId($user_id)->update([
            'is_seen' => self::READ
        ]);

        return response()->json(['success' => true], 200);
    }


    /**
     * Get last {$take} conversations with all users for a user.
     *
     * @param  int  $fish_id
     * @param  int  $take  (optional)
     * @return collection
     */
    public static function msgConversations($fish_id, $take = 10)
    {
        $collection    = self::whereFishId($fish_id);
        $totalRecords  = $collection->count();
        $conversations = $collection->take($take)
            ->skip($totalRecords - $take)
            ->get();
        return $conversations;
    }

    /**
     * Get with all users in the messages.
     *
     * @param  int  $user_id
     * @return array
     */
    public static function msgUsers($user_id){
        $message = Message::select('receiver_id')
                    ->whereUserId($user_id)
                    ->groupBy('receiver_id')
                    ->get();

        $users = array();
        foreach (json_decode($message, true) as $item) {
            $item['user'] = Message::msgUser($item['receiver_id']);
            $users[] = $item;
        }

        return $users;
    }

    /**
     * 新規登録
     *
     * @param  array $attributes
     *
     */
    public static function register(array $attributes)
    {
        \DB::beginTransaction();
        try {

            if (!empty($attributes['photo'])) {
                $_photo = $attributes['photo'];

                $paths = Photo::makePath(\Auth::user()->id, $_photo->getClientOriginalExtension());
                $img_paths[] = $paths['server_path'];
                FileHelper::storeResizeImg($_photo->path(), $paths['server_path'], 300, null);

                $attributes['img_url'] = $paths['public_path'];
            }

            $attributes['fish_id'] = $attributes['fish_id'];
            $attributes['user_id'] = \Auth::user()->id;
            $attributes['receiver_id'] = $attributes['receiver_id'];
            $attributes['message'] = preg_replace('/\A[\x00\s]++|[\x00\s]++\z/u', '', htmlspecialchars($attributes['message']));

            $msg = self::create($attributes);

            \DB::commit();
            return $msg;
        } catch (\Exception $e) {
            \Log::error(get_class().':create(): '.$e->getMessage());
            \DB::rollback();
            \File::delete($img_paths);
            return false;
        }
    }

    /**
     * バリデーションを実施
     *
     * @return array
     */
    public static function validate()
    {
        $val = [
            'message' => ['nullable', 'string', 'max:1000'],
            'photo' => ['nullable','image', 'max:5000'],
            'photo.*.tmp_path' => ['nullable', 'string'],
            'photo.*.mime' => ['nullable', Rule::in(['image/jpeg', 'image/png', 'image/gif'])],
        ];

        return $val;
    }

    /**
     * Send message notification automatically
     *
     * @param array $message
     */
    public function sendMessageNotification($message)
    {
        $this->notify(new NotifyMessage($message));
    }
}
