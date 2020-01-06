<?php

namespace App\Http\Controllers;

use App\Http\Requests\Blog\AddPost;
use App\Http\Requests\Blog\EditPost;
use App\Http\Requests\Blog\UploadImagePost;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Blog\Photo;
use App\Models\User;

class BlogController extends Controller
{
    /*
    * ブログ新規作成ページ
    * @return view
    */
    public function addView()
    {
        $default = Blog::getProperties();
        //URL設定
        return view('blog.add', ['blog' => $default]);
    }

    /**
     * ブログ新規作成
     * @return \Illuminate\Http\Response
     */
    public function create(AddPost $request)
    {
        $data = $request->all();

        //データベースへの登録
        $rtn = Blog::register($data);
        if ($rtn === false) {
            return redirect()->back()
                    ->withInput()
                    ->with(['error' => 'システムエラーが発生しました。再度お試しいただくか、お問い合わせください。']);
        }

        $url = url('/mypage/blog/'.$rtn['id'].'/edit');
        return redirect($url)
                ->with(['status' => 'ブログの作成に成功しました。']);
    }

//======================================================================
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

//======================================================================
    /*
    * ブログ編集ページ
    */
    public function editView(Blog $blog)
    {
        //ユーザー認証
        if (!$blog->isOwner()) {
            $url = url('blog/'. $blog->id);
            return redirect($url);
        }

        $data = $blog;
        $photos = $blog->photos;
        $default = Blog::getProperties();

        $data['photo_id'] = $photos->pluck('id')->toArray() + $default['photo'];
        $data['photo'] = $photos->pluck('file_name')->toArray() + $default['photo'];
        //作成済みのブログをフォームに適用する。
        return view('blog.edit', ['blog' => $data]);
    }

    /*
    *　ブログ編集
    */
    public function update(EditPost $request, Blog $blog)
    {
        $data = $request->all();

        //更新
        $rtn = $blog->updater($data);
        if ($rtn === false) {
            return redirect()->back()
                    ->withInput()
                    ->with(['error' => 'システムエラーが発生しました。再度お試しいただくか、お問い合わせください。']);
        }

        return redirect()->back()
                ->with(['status' => '変更内容を保存しました。']);
    }

//======================================================================
    /*
    * ブログ一覧ページ
    * @return view
    */
    public function indexView(User $user, Blog $blog)
    {
        $blogs = $blog::getPublishedList($user);
        return view('blog.list', compact('blogs', 'user'));
    }

//======================================================================
    /*
    * ブログ詳細ページ
    * @return view
    */
    public function detailView(Blog $blog)
    {
        if (!$blog->isPublish()) {
            //公開済みではないブログ
            return abort(404);
        }
        $user = $blog->user;

        //前後のブログを取得
        $previous = $blog->previous();
        $next = $blog->next();
        return view('blog.detail', compact('blog', 'user', 'previous', 'next'));
    }

//======================================================================
    /*
    * ブログ管理ページ
    * @return view
    */
    public function manageView()
    {
        $blogs = Blog::getSelfList();
        return view('blog.mypage_list', compact('blogs'));
    }

//======================================================================

    public function delete(Blog $blog)
    {
        if (!$blog->isOwner()) {
            return abort('404');
        }

        $rtn = $blog->execDelete();
        if ($rtn === false) {
            return redirect()->back()
                    ->with(['error' => 'システムエラーが発生しました。再度お試しいただくか、お問い合わせください。']);
        }

        return redirect('mypage/blog')
                ->with('status', '「'.$blog->title.'」を削除しました。');
    }


    public function list(Request $request, Blog $blog)
    {
        $count = $request->get('count', 20);
        $search = $request->get('search', null);
        $blogs = $blog::getPublishedListAll($count, 'created_at', $search);
        $total_count = $blogs->total();
        $params = $request->all();
        return view('blog.list_all', compact('blogs', 'total_count', 'count', 'sort', 'search', 'params'));
    }
}
