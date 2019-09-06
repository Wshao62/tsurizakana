<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MessagePost;
use App\Events\MessageEvent;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Persist message to database
     *
     * @param  MessagePost $request
     * @return Response
     */
    public function sendMessage(MessagePost $request, Message $msg)
    {
        $user = Auth::user();

        $data = $request->all();
        unset($data['_token']);

        $message = $msg->register($data);

        broadcast(new MessageEvent($user, $message))->toOthers();

        return response()->json([
            'success' => true,
            'message' => $message,
            'user' => $user,
        ], 200);
    }

    /**
     * Load messages view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response.
     */
    public function fetchMessage(Request $request)
    {
       return $this->messanger($request);
    }

    /**
     * Load more messages.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response.
     */
    public function moreMessage(Request $request)
    {
        return $this->messanger($request);
    }

    /**
     * get messages
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response.
     */
    public function messanger($request){
        if ($request->ajax()) {
            $msg = Message::mssgFetch(
                $request->fish_id,
                $request->take
            );
            
            $message = [];
            foreach ($msg as $item) {
                $date = new Carbon($item['created_at']['date']);
                $message[$date->format("Y年m月d日")][] = $item;
            }

            $messagesCount = Message::whereFishId($request->fish_id)->count();

            $view = view('parts.message.template_message_form', compact('message'))->render();
            return response()->json([
                'view' => $view,
                'messagesCount' => $messagesCount
            ], 200);
        }
    }

    /**
     * Make a message seen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function makeSeen(Request $request)
    {
        Message::msgSeen($request->fish_id);
        return response()->json(['success' => true], 200);
    }

    /**
     * Mark a message as read all.
     *
     * @return Response
     */
    public function makeMark()
    {
        Message::msgMark(\Auth::user()->id);
        return response()->json(['success' => true], 200);
    }
}
