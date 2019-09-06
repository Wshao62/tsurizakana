<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogManagementController extends Controller
{
    public function lists(Request $request)
    {
        $data = $request->all();
        $user_id = null;
        if (!empty($data['user_id']) && is_numeric($data['user_id']) && $data['user_id'] > 0) {
            $user_id = $data['user_id'];
        }
        return view('admin.blog.blog_management', [
                'users' => User::all(),
                'user_id' => $user_id,
                'status_ary' => Blog::STATUS_NAMES,
            ]);
    }

    public function getBlogDataTables(Request $request)
    {
        return response()->json(Blog::getDataTable($request->all()));
    }

    public function blogDelete(Blog $blog){
        $rtn = $blog->adminDelete($blog->id);

        if ($rtn == false) {
            return redirect('/admin/blog')
                    ->with(['error' => 'システムエラーが発生しました。しばらく待ってから再度お試しください。それでも失敗する場合はお問い合わせください。']);
        }

        return redirect('/admin/blog')->with(['status' => 'ブログの削除に成功致しました。']);
    }
}