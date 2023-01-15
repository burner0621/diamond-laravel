<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class ChatController extends Controller
{

    protected Message $message;

    /**
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }


    public function create(Request $request)
        {
            $seller = $request->seller;
            $user_id = Auth::user()->id;

            if($seller){
                $is_connected = Message::where(['user_id' =>$user_id,'dest_id' => $seller])->count();
                if($is_connected == 0){
                    $message = new Message;
                    $message->user_id = $user_id;
                    $message->dest_id = $seller;
                    $message->save();
                }
            }
            // $chat_content = Message::where(['user_id'=>$user_id,'dest_id'=>$seller])
            //                         ->orWhere(['user_id'=>$seller,'dest_id'=>$user_id])
            //                         ->get();
            $chat_content = DB::select(DB::raw('SELECT * FROM `messages` WHERE (user_id='.$user_id.' AND dest_id='.$seller.') OR (user_id='.$seller.' AND dest_id='.$user_id.');'));

            $side_info = DB::select(DB::raw('SELECT a.*, u.`first_name`,u.`last_name`,u.`id` FROM (SELECT m.* FROM messages m WHERE id IN (SELECT MAX(id) FROM messages GROUP BY dest_id) AND user_id = '.$user_id.') AS a LEFT JOIN users u ON a.dest_id = u.id  ORDER BY a.created_at DESC'));

            return view('chat.create', compact('side_info','chat_content','seller','user_id'));
        }

    public function contentFetchByClientId(Request $request){
        $client_id = $request->client_id;
        $user_id = Auth::user()->id;
        $chat_content = Message::where(['user_id'=>$user_id,'conversation_id'=>$client_id])
                                    ->orWhere(['user_id'=>$client_id,'conversation_id'=>$user_id])
                                    ->get();
        $chat_content = DB::select(DB::raw('SELECT * FROM `messages` WHERE (user_id='.$user_id.' AND conversation_id='.$client_id.') OR (user_id='.$client_id.' AND conversation_id='.$user_id.');'));
        return response()->json([
            'result'        => true,
            'chat_content'  => $chat_content,
        ]);
    }

    public function filter(Request $request){
        $filter = $request->filter;
        $user_id = Auth::user()->id;
        if(strlen($filter)==0){
            $side_info = DB::select(DB::raw('SELECT a.*, u.`first_name`,u.`last_name` FROM (SELECT m.* FROM messages m WHERE id IN (SELECT MAX(id) FROM messages GROUP BY dest_id) AND user_id = '.$user_id.') AS a LEFT JOIN users u ON a.dest_id = u.id   ORDER BY a.created_at DESC'));
            return view('chat.create', compact('side_info'));
        }else if(strlen($filter)!=0) {
            $side_info = DB::select(DB::raw('SELECT a.*, u.`first_name`,u.`last_name` FROM (SELECT m.* FROM messages m WHERE id IN (SELECT MAX(id) FROM messages GROUP BY dest_id) AND user_id = '.$user_id.') AS a LEFT JOIN users u ON a.dest_id = u.id  WHERE u.`first_name`=".$filter" OR u.`last_name`=".$filter" ORDER BY a.created_at DESC'));
            return view('chat.create', compact('side_info'));
        }

    }

    public function getNameById($user_id){
       return  $user_name = User::where('id',$user_id)->get('first_name');
    }


    public function create_chat_room(Request $request,$conversation_id) {

        $user = Auth::user();
        $user_id = $user->id;
        if ($user_id == $conversation_id)
        {
            return abort(404);
        }
        $is_created_chat_room = Message::where(['user_id' => $user_id, 'conversation_id' => $conversation_id])
                                        ->groupBy('user_id')
                                        ->count();
        $this->message->seenAll($conversation_id,$user_id);

        if($is_created_chat_room == 0){
            $message = new Message;
            $message->user_id = $user_id;
            $message->conversation_id = $conversation_id;
            $message->save();
        }

        $query = '
SELECT   c.user_id , max(cnt) as cnt from (
SELECT a.user_id,b.cnt FROM
            (SELECT `user_id` FROM `messages` WHERE `conversation_id` = '.$user_id.' and user_id != '.$user_id.'
GROUP BY (user_id))as a
            LEFT JOIN
            (SELECT `user_id`, COUNT(*)
            as cnt FROM `messages` WHERE `conversation_id` = '.$user_id.' and user_id != '.$user_id.'

             and is_seen=0  GROUP BY (user_id)
            )as b
            on a.user_id = b.user_id
        UNION ALL
        SELECT `conversation_id` as user_id,"0" as cnt FROM `messages` WHERE `user_id` = '.$user_id.'
         and conversation_id!= '.$user_id.' GROUP By `conversation_id`
         )as c GROUP BY c.user_id
        '
        ;


        $side_info = DB::select(DB::raw($query));
        $chat_content = DB::select(DB::raw('SELECT * FROM `messages` WHERE (user_id='.$user_id.' AND conversation_id='.$conversation_id.') OR (user_id='.$conversation_id.' AND conversation_id='.$user_id.'); '));
        return view('chat.create', compact('side_info','chat_content','conversation_id','user_id'));
    }

    public function message_log(Request $request){
        $data = $request->data;
        $message_log = new Message;
        $message_log->user_id = $data['user_id'];
        $message_log->conversation_id = $data['conversation_id'];
        $message_log->message = $data['chat_msg'];
        $message_log->save();
        $chatMessArr = explode(":",$data['chat_msg']);
        $isUploadFile = isset($chatMessArr[0]) && $chatMessArr[0] == "upload_ids" && isset($chatMessArr[1]);
        $file = "";
        if ($isUploadFile)
        {
            $file = Upload::find($chatMessArr[1]);
        }
        $user = User::find($data['user_id']);

        return response()->json([
            'result'        => true,
            'message_log'  => $message_log,
            "upload_file" => $isUploadFile && $file ? $file->getFileFullPath() :'',
            "file" => $file,
            "link_download" => $isUploadFile && $file ?  route('download_file',base64_encode($file->id)) : "",
            "user"=>[
                "full_name" => $user->full_name,
                'image_url' => $user->image_url
            ]
        ]);
    }

    public function getChatInFormationBy(Request $request)
    {

        $file = Upload::find($request->file_id);
        $user = User::find($request->user_id);
        $conversation = User::find($request->conversation_id);

        return response()->json([
            "file" => $file,
            "user"=>[
                "full_name" => $user->full_name,
                'image_url' => $user->image_url
            ],
            "conversation"=>[
                "full_name" => $conversation->full_name,
                'image_url' => $conversation->image_url
            ],
            "link_download" => $request->file_id ? route('download_file',base64_encode($request->file_id)) :"",
            'path'=> $request->file_id ? $file->getFileFullPath() :""
        ]);
    }


}
