<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Fish\AddPostRequests;
use App\Http\Requests\Fish\EditPostRequests;
use App\Models\Fish\Category;
use App\Models\FishRequests;
use App\Models\Fish;
use App\Models\User;
use App\Models\UserPhoto;
use App\Models\UserRating;

use Session;
use Illuminate\Support\Facades\Validator;

class FishRequestController extends Controller
{
    /**
     * リクエスト登録フォームを表示
     */
    public function showCreateForm()
    {
        if (!\Auth::user()->isIdentified()) {
            return redirect('/mypage/blog');
        }

        $data = Session::exists('request_data')
                ? Session::get('request_data')
                : FishRequests::getProperties();
        return view('fish.request.request_add', $data);
    }

    /**
     * リクエスト魚登録確認画面
     *
     * @param  AddPostRequests $request
     *
     */
    public function showConfirm(AddPostRequests $request)
    {
        if (!\Auth::user()->isIdentified()) {
            abort(403);
        }
        $data = $request->all();

        Session::put('request_data', $data);
        Session::save();

        return view('fish.request.request_confirm', [
                    'fish_data' => $data,
                ]);
    }

    /**
     * リクエスト魚を登録
     *
     * @param  Request $request
     * @param  FishRequests $request
     */
    public function store(Request $request, FishRequests $fish)
    {
        if (!\Auth::user()->isIdentified()) {
            abort(403);
        }

        if (!Session::exists('request_data')) {
            return redirect('/mypage/fish/request')
                    ->with(['error' => 'セッション切れか、不正な画面遷移です。']);
        }

        $data = Session::get('request_data');
        $rtn = $fish::register($data);
        if ($rtn === false) {
            return redirect('/mypage/fish/request/add')
                    ->with(['error' => 'システムエラーが発生しました。しばらく待ってから再度お試しください。それでも失敗する場合はお問い合わせください。']);
        }

        Session::forget('request_data');
        return redirect('/mypage/fish/request/complete');
    }

    /**
     * 完了画面
     */
    public function showComplete()
    {
        return view('fish.request.request_complete');
    }

    /**
     * 編集画面
     *
     * @param  FishRequests $fish
     *
     */
    public function edit(FishRequests $fish)
    {
        if (!$fish->isOwner()) {
            abort(403);
        }
        $data = $fish->toArray();

        return view('fish.request.request_edit', $data);
    }

    /**
     * 更新をかける
     *
     * @param  EditPostRequests $request
     * @param  FishRequests $fish
     *
     */
    public function update(EditPostRequests $request, FishRequests $fish)
    {
        $data = $request->all();
        unset($data['_token']);

        $rtn = $fish->updater($data);
        return redirect('/mypage/fish/request/'.$rtn['id'].'/edit')
                ->with(['status' => '売魚情報を変更しました。']);
    }

     /**
      * Get item count for search string
      *
      * @param  Request $request
      *
      * @return void
      */
    public function category(Request $request)
    {
        $data = $request->all();
        $categories = FishRequests::fetch($data['keyword']);
        return count($categories);
    }

    /**
     * Get list of all request from Fish Request table
     */
    public function list(Request $req)
    {
        $custom = ['url' => url('/')];
        \App\Models\User\DeviceToken::sendPushNotification(\Auth::id(), "売魚が受け取られました！取引相手の評価をお願いします。", $custom);

        if (\Request::is('mypage/fish/request') &&!\Auth::user()->isIdentified()) {
            return redirect('/mypage/blog');
        }
        //get Uniform Resource Identifier to be used for  parameter
        $uri = $_SERVER["REQUEST_URI"];
        $indentifier = $req->route()->named('all');
        $isGuest = false;
        $query = new FishRequests();

        if (is_null(\Auth::user())) {
            $isGuest = true;
        }

        $limit = 5;
        $data = $this->search($query, $uri, $indentifier, $isGuest)->paginate($limit);


        $inputs = $req->all();
        $list = [
            'fishrequests' => $data,
            'status' => array_key_exists('status', $inputs) ? $inputs['status'] : '',
            'area' => array_key_exists('area', $inputs) ? $inputs['area'] : '',
            'category' => !empty($inputs['category']) ? $inputs['category'] : '',
            'username' => !empty($inputs['username']) ? $inputs['username'] : '',
            'date' => !empty($inputs['date']) ? $inputs['date'] : '',
            'limit' => $limit,
        ];

        if ($indentifier === true) {
            return view('fish.request.request_list')->with($list);
        }
        return view('fish.request.request_mypage_list')->with($list);
    }

    /**
     * Scope a query that matches a parameter search of term.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $term
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function search($query, $term, $identifier, $isGuest)
    {
        $param = explode('?', $term);

        if (!$isGuest) {
            $query = $identifier != true ? $query->where('user_id', '=', \Auth::user()->id) : $query;
        }

        $query = $this->joinTable($query, $isGuest);

        if (count($param) > 1) {
            $param = $param[1];
            $query = $this->setClause($query, $param);
        }

        return $query;
    }

    /**
     * Join two table FishRequest and users
     * to display the list.
     */
    public function joinTable($query, $isGuest)
    {

        $status = \DB::raw("(CASE fish_requests.status when 1 then '表示中' when 0 then '表示終了' end) as status");
        $category = "category_name";
        $category_id = "category_id";
        $area = "users.public_address";
        $name = "users.name";
        $user_id = "fish_requests.user_id";
        $date = \DB::raw("date_format(request_date, '%Y/%m/%d') as request_date");
        $id = \DB::raw("fish_requests.id as id");
        $fishCount = \DB::raw("(select count(fish.id) from fish where fish.id = fish_requests.fish_id and fish.status = 1  ) as fishcount");
        $fishName = \DB::raw("(select fish.fish_category_name from fish where fish.id = fish_requests.fish_id and fish.status = 1  ) as fish_category_name");

        if (!$isGuest) {
            $offerCount = \DB::raw("(select count(fish_offers.id) from fish_offers where fish_offers.request_id = fish_requests.id and fish_offers.offer_user_id = " . \Auth::user()->id . " ) as offer_count");
            $isOwner = \DB::raw("(case when fish_requests.user_id = " . \Auth::user()->id . " then true else false end) as isOwner");
        } else {
            $offerCount = \DB::raw("0 as offer_count");
            $isOwner = \DB::raw("false as isOwner");
        }

        $query = $query
                    ->select($id, $status, $category, $category_id, $area, $name, $user_id, $date, $fishCount, $fishName, $offerCount, $isOwner)
                    ->join('users', 'user_id', '=', 'users.id')
                    ->orderBy('fish_requests.updated_at', 'DESC');

        return $query;
    }

    /**
     * Set the Where Clause from $param
     * @return $query with the parameter
     */
    public function setClause($query, $param)
    {
        $getParam = explode('&', $param);

        for ($i=0; $i < count($getParam); $i++) {
            if (explode('=', $getParam[$i])[1] <> "") {
                $name = explode('=', $getParam[$i])[0];

                switch ($name) {
                    case 'status':
                        $query = $query->where("status", "=", htmlspecialchars($_GET["status"]));
                        break;
                    case 'category':
                        $value = htmlspecialchars($_GET["category"]);
                        $query = $query->where("category_name", "like", "%" . htmlspecialchars($_GET["category"]) . "%");
                        break;
                    case 'area':
                        $query = $query->where("prefecture", "=", htmlspecialchars($_GET["area"]));
                        break;
                    case 'username':
                        $query = $query->where("name", "like", "%" . htmlspecialchars($_GET["username"]) . "%");
                        break;
                    case 'date':
                        $query = $query->where(\DB::raw("date_format(request_date, '%Y/%m/%d')"), "=", htmlspecialchars($_GET["date"]));
                        break;
                }
            }
        }
        return $query;
    }

}
