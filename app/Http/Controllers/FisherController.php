<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Models\User;

class FisherController extends Controller
{

    /**
     * 釣り人一覧ページ
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Request $request, User $user)
    {
        $count = $request->get('count', 20);
        $search = $request->get('search', null);
        $users = $user::getFisherListAll($count, 'created_at', $search);
        $total_count = $users->total();
        $params = $request->all();
        return view('fisher.list_all', compact('users', 'total_count', 'count', 'sort', 'search', 'params'));
    }

}
