<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Fish\AddPost;
use App\Http\Requests\Fish\EditPost;
use App\Http\Requests\Fish\UploadImagePost;
use App\Http\Requests\Fish\SearchGet;
use App\Http\Requests\Fish\RatePost;
use App\Http\Requests\Fish\RejectPost;
use App\Models\User;
use App\Models\Fish;
use App\Models\Fish\Category;
use App\Models\Fish\Comment;
use App\Models\Fish\Photo;
use App\Models\Message;
use App\Models\UserRating;
use Intervention\Image\ImageManagerStatic as Image;
use Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CategorySearchPost;
use Carbon\Carbon;

class FishController extends Controller
{

    /**
     * 売魚登録フォームを表示
     */
    public function showCreateForm()
    {
        if (!\Auth::user()->isIdentified()) {
            return redirect('/mypage/blog');
        }
        $default = Fish::getProperties();
        if (Session::exists('fish_data')) {
            $val = Session::get('fish_data');
            $val['photo'] = $val['photo'] + $default['photo'];
            $default = $val;
        }
        $data = $default;
        return view('fish.add', $data);
    }

    /**
     * 画像をアップロード
     *
     * @param  UploadImagePost $request
     *
     * @return json
     */
    public function uploadImage(UploadImagePost $request)
    {
        $photo = $request->file('photo');

        $url = Photo::uploadTmpImage($photo);
        if ($url === false) {
            return response()->json(['message' => 'システムエラーです、再度お試しください。'], 500);
        }

        return response()->json(['url' => $url]);
    }

    /**
     * 売魚登録確認画面
     *
     * @param  AddPost $request
     *
     */
    public function showConfirm(AddPost $request)
    {
        $data = $request->all();
        unset($data['dummy_file']);
        Session::put('fish_data', $data);
        Session::save();
        return view('fish.confirm', [
                    'fish_data' => $data,
                ]);
    }

    /**
     * 売魚を登録
     *
     * @param  Request $request
     *
     */
    public function store(Request $request, Fish $fish)
    {
        if (!Session::exists('fish_data') || (Validator::make(Session::get('fish_data'), $fish::validate()))->fails()) {
            return redirect('/mypage/fish/add')
                    ->with(['error' => 'セッション切れか、不正な画面遷移です。再度入力して手続きを進めて下さい。']);
        }
        $data = Session::get('fish_data');
        $rtn = $fish::register($data);
        if ($rtn === false) {
            return redirect('/mypage/fish/add')
                    ->with(['error' => 'システムエラーが発生しました。しばらく待ってから再度お試しください。それでも失敗する場合はお問い合わせください。']);
        }

        Session::forget('fish_data');
        return view('fish.complete', [ 'fish_data' => $rtn ]);
    }

    /**
     * 編集画面
     *
     * @param  Fish $fish
     *
     */
    public function edit(Fish $fish)
    {
        if (!$fish->isOwner() || !$fish->canEdit()) {
            abort(403);
        }
        $default = Fish::getProperties();
        $data = $fish->toArray();
        $photos = $fish->photos;
        $data['photo'] = $photos->pluck('file_name')->toArray() + $default['photo'];
        $data['photo_id'] = $photos->pluck('id')->toArray() + $default['photo'];

        return view('fish.edit', $data);
    }

    /**
     * 更新をかける
     *
     * @param  EditPost $request
     * @param  Fish $fish
     *
     */
    public function update(EditPost $request, Fish $fish)
    {
        $data = $request->all();
        unset($data['_token']);

        $rtn = $fish->userUpdater($data);
        if ($rtn === false) {
            return redirect()->back()
                    ->with(['error' => 'システムエラーが発生しました。しばらく待ってから再度お試しください。それでも失敗する場合はお問い合わせください。']);
        }
        return redirect('/mypage/fish/'.$rtn['id'].'/edit')
                ->with(['status' => '売魚情報を変更しました。']);
    }

    /**
     * 削除の実施
     *
     * @param  Request $request
     * @param  Fish $fish
     *
     */
    public function delete(Request $request, Fish $fish)
    {
        if (!$fish->isOwner() || !$fish->canDelete()) {
            abort('403');
        }

        $rtn = $fish->deleter();
        if ($rtn === false) {
            return redirect('/mypage/fish')
            ->with(['error' => 'システムエラーが発生しました。しばらく待ってから再度お試しください。それでも失敗する場合はお問い合わせください。']);
        }
        return redirect('/mypage/fish')->with(['status' => '[ID:'.$fish->id.']'.$fish->fish_category_name. 'を削除しました。']);
    }

    /**
     * フロント側の売魚一覧
     *
     * @param  Request $request
     *
     */
    public function list(SearchGet $request)
    {
        $limit = 20;
        $default_values = [
            'keyword' => "",
            'area' => "",
            'limit' => $limit,
            'order' => "new",
            'is_open' => 0,
        ];
        $data = $request->all() + $default_values;

        $title = '売魚一覧';

        $user = null;
        if (!empty($data['user_id'])) {
            if ($user = User::find($data['user_id'])) {
                $title = $user->name. 'さんの'. $title;
            } else {
                $data['user_id'] = null;
            }
        }

        $category = null;
        if (!empty($data['category_id'])) {
            if ($category = Category::find($data['category_id'])) {
                $title = $category->name. ': '. $title;
            } else {
                $data['category_id'] = null;
            }
        }

        $fish = Fish::search($data);
        return view('fish.list', [
                'fish' => $fish,
                'user' => $user,
                'category' => $category,
                'attributes' => $data,
                'title' => $title,
            ]);
    }

    /**
     * 魚詳細画面
     *
     * @param  Fish $fish
     *
     */
    public function detail(Fish $fish)
    {
        return view('fish.detail', [
            'fish' => $fish,
            'seller' => $fish->seller,
            'seller_rates' => $fish->seller->getRateCounts(),
            'buyer_rates' => $fish->buyer->getRateCounts(),
            'photo' => $fish->photos,
            'comments' => $fish->comments,
            'other_fish' => Fish::whereStatus(Fish::STATUS_PUBLISH)->where('id', '<>', $fish->id)->latest()->with('onePhoto')->limit(4)->get(),
        ]);
    }

    /**
    *
    * Save users comment
    *
    * @param Request $request
    */
    public function saveComment(Request $request, Comment $comment, Fish $fish)
    {
        $data = $request->all();
        $fish_id = $fish->id;

        $saveComment = $comment->saveComment($fish_id, $data['comment']);
        if (!$saveComment) {
            return 'failed';
        }

        return 'success';
    }

    /**
     * マイページ側の売魚一覧
     *
     * @param  Request $request
     *
     * @return void
     */
    public function mypageList(Request $request)
    {
        if (!\Auth::user()->isIdentified()) {
            return redirect('/mypage/blog');
        }

        $data = $request->all();
        $type = "";
        if (!empty($data['type']) && in_array($data['type'], Fish::LIST_ALL_STATUS)) {
            $type = $data['type'];
        }
        $fish =[];
        $limit = 10;
        $fish = Fish::getMyList($type, $limit);
        return view('fish.mypage_list', [
                'fish' => $fish,
                'type' => $type,
            ]);
    }

    /**
     * 売魚詳細(メッセージ画面)
     *
     * @param  Fish $fish
     */
    public function mypageDetail(Fish $fish)
    {
        if (!$fish->isTransaction() || (!$fish->isOwner() && !$fish->isBuyer())) {
            abort(404);
        }

        $user = [];
        if ($fish->isOwner()) {
            $user = $fish->buyer;
        } else {
            $user = $fish->seller;
        }

        //Fetch all messages
        $msg = [];
        $message = Message::mssgFetch($fish->id);
        foreach ($message as $item) {
            $date = new Carbon($item['created_at']['date']);
            $msg[$date->format("Y年m月d日")][] = $item;
        }

        //seen message
        Message::msgSeen($fish->id);

        return view('fish.mypage_detail', [
            'fish' => $fish,
            'partner' => $user,
            'message' => $msg,
            'buyer_rates' => $fish->buyer->getRateCounts(),
            'seller_rates' => $fish->seller->getRateCounts(),
            'messagesCount' => count($message)
        ]);
    }

    public function recieve(Fish $fish)
    {
        if ((!$fish->isOwner() && !$fish->isBuyer()) || $fish->status !== Fish::STATUS_DELIVERY) {
            abort(404);
        }

        $rtn = $fish->execRecieve();
        if ($rtn === false) {
            return redirect()->back()
                    ->with(['error' => 'システムエラーが発生しました。しばらく待ってから再度お試しください。それでも失敗する場合はお問い合わせください。']);
        }

        return redirect('/mypage/fish/'.$fish->id)
            ->with(['status' => '受け取り処理が正しく終わりました。取引相手の評価を入力をお願いします。']);
    }

    /**
     * ユーザを評価
     *
     * @param  RatePost $req
     * @param  Fish $fish
     */
    public function rateUser(RatePost $req, Fish $fish)
    {
        $data = $req->all();
        $rtn = $fish->rate($data);
        if ($rtn === false) {
            return redirect()->back()
                    ->withInput()
                    ->with(['error' => 'システムエラーが発生しました。しばらく待ってから再度お試しください。それでも失敗する場合はお問い合わせください。']);
        }
        return redirect()->back()->with(['status' => '評価が完了し、取引が完全に終了しました。'.config('app.name').'をご利用いただきありがとうございました。']);
    }

    /**
     * 取引を中止
     *
     * @param  RejectPost $req
     * @param  Fish $fish
     */
    public function reject(RejectPost $req, Fish $fish)
    {
        $data = $req->all();
        $rtn = $fish->execReject($data);
        if ($rtn === false) {
            return redirect()->back()
                    ->withInput()
                    ->with(['error' => 'システムエラーが発生しました。しばらく待ってから再度お試しください。それでも失敗する場合はお問い合わせください。']);
        }

        // キャンセルされた商品情報を複製して、自動で再出品する
        $fish->copy($fish);

        return redirect('/mypage/fish')->with(['status' => '取引を中止に成功いたしました。その他問題がありましたら、別途運営へお問い合わせをお願いいたします。']);
    }

    /**
     * 検索文字列に対するカテゴリーのjsonを取得する
     *
     * @param  CategorySearchPost $request
     *
     * @return void
     */
    public function category(CategorySearchPost $request)
    {
        $data = $request->all();
        $categories = Category::searchNames($data['keyword']);
        return response()->json($categories);
    }
}
