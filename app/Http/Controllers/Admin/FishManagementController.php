<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fish;
use App\Models\User;
use App\Models\Fish\Category;
use App\Http\Requests\Admin\FishRequest;
use App\Http\Requests\Admin\FishListPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Message;
use Carbon\Carbon;


use Session;

class FishManagementController extends Controller
{
    public function lists(Request $request)
    {
        $statusArray = $this->getStatus();

        $data = $request->all();
        $seller_id = null;
        $buyer_id = null;
        if (!empty($data['seller_id']) && is_numeric($data['seller_id']) && $data['seller_id'] > 0) {
            $seller_id = $data['seller_id'];
        }
        if (!empty($data['buyer_id']) && is_numeric($data['buyer_id']) && $data['buyer_id'] > 0) {
            $buyer_id = $data['buyer_id'];
        }
        return view('admin.fish.fish_management', [
            'users' => User::all(),
            'seller_id' => $seller_id,
            'buyer_id' => $buyer_id,
            'statusArray' => $statusArray,
            ]);
    }

    public function fishDetail(Fish $fish)
    {
        $fish['photo'] = $fish->onePhoto->file_name;
        $fish['name'] = $fish->seller->toArray()['name'];
        $fish['public_address'] = $fish->seller->toArray()['public_address'];

        $fish = $fish->toArray();
        $category = $this->getCategory()->orderBy('name')->get()->toArray();
        $userInfo = $this->getUserInfo()->orderBy('name')->get()->toArray();
        $statusArray = $this->getStatus();

        $status = Session::get('status');
        Session::forget('status');
        Session::forget('errors');

        return view('admin.fish.edit',[
            'fishInfo' => $fish,
            'category' => $category,
            'userInfo' => $userInfo,
            'statusArray' => $statusArray,
            'status' => $status,]);
    }

    public function fishDelete(Fish $fish){

        if($fish->status !== 1){
            abort(403);
        }

        $rtn = $fish->adminDelete($fish['id']);

        if ($rtn == false) {
            return redirect('/admin/fish/' . $fish['id'] . '/edit')->withInput()
                    ->with(['error' => 'システムエラーが発生しました。しばらく待ってから再度お試しください。それでも失敗する場合はお問い合わせください。']);
        }

        return redirect('/admin/fish')->with(['status' => '削除致しました。']);
    }

    public function fishUpdate(FishRequest $request){
        $fish = new Fish;
        $data = $request->all();
        $isValid = true;
        Session::forget('errors');


        $validator = Validator::make($data, Fish::validate($data['id'], 'admin_edit'));

        if($data['seller_id'] === $data['buyer_id']){
            $isValid = false;
        }

        if ($validator->fails() || !$isValid) {

            if(!$isValid){
                $validator->getMessageBag()->add('seller_id', '購入者と異なるユーザーを選択してください。');
                $validator->getMessageBag()->add('buyer_id', '販売者と異なるユーザーを選択してください。');
            }

            Session::put('errors', $validator->messages());
            Session::put('updating_fish', $data);
            return redirect()->back()->withInput();
        }

        Session::forget('errors');
        Session::put('updating_profile', $data);
        Session::save();

        unset($data['_token']);
        unset($data['public_address']);

        $rtn = $fish->adminUpdater($data);

        if ($rtn == false) {
            return redirect('/admin/fish/' . $data['id'] . '/edit')->withInput()
                    ->with(['error' => 'システムエラーが発生しました。しばらく待ってから再度お試しください。それでも失敗する場合はお問い合わせください。']);
        }

        Session::put('status', '更新に成功致しました。');

        return redirect('/admin/fish/' . $data['id'] . '/edit');
    }

    public function getFishData(FishListPost $request)
    {
        return response()->json(Fish::getDataTable($request->all()));
    }

    public function fishRestart(){
        $uri = $_SERVER['REQUEST_URI'];
        $fishID = explode('/',$uri)[count(explode('/',$uri))-2];

        $rtn = Fish::withTrashed()->find($fishID)->restore();

        if ($rtn == false) {
            return redirect('/admin/fish')
                    ->with(['error' => 'システムエラーが発生しました。しばらく待ってから再度お試しください。それでも失敗する場合はお問い合わせください。']);
        }

        return redirect('/admin/fish')->with(['status' => '復元致しました。']);
    }

    public function getCategory(){
        return new Category;
    }

    public function getUserInfo(){
        return new User;
    }

    public function getStatus(){
        return Fish::STATUS_NAMES;
    }

    public function userMessage(Request $request){

        $conversations = Message::where('fish_id', '=', $request->route('user'))
                        ->get();


        $message = [];
        $ctr = 0;
        $user_id = 0;
        $receiver_id = 0;
        $user_name = "";
        $receiver_name = "";

        foreach (json_decode($conversations, true) as $item) {
            if($ctr == 0){
                $user_name = User::whereId($item['user_id'])->first()->name;
                $receiver_name = User::whereId($item['receiver_id'])->first()->name;
                $ctr++;
            }

            $user_id = $item['user_id'];
            $receiver_id = $item['receiver_id'];

            $date = new Carbon($item['created_at']);
            $item['name'] = $user_name;
            $message[$date->format("Y年m月d日")][] = $item;


        }

        $users = Message::msgUsers($request->route('user'));

        return view('admin.fish.message',[
            'message' => $message,
            'user' => $users,
            'receiver_id' => $receiver_id ,
            'id' => $user_id ,
            'user_name' => $user_name ,
            'receiver_name' => $receiver_name,
       ]);
    }
}