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

class SaleController extends Controller
{

    /**
     * 売上管理画面を表示
     */
    public function index()
    {
        return view('sale.index');
    }

    /**
     * 売上履歴画面を表示
     */
    public function history()
    {
        return view('sale.history');
    }

    /**
     * 振込申請画面を表示
     */
    public function application()
    {
        return view('sale.application.index');
    }

    /**
     * 振込先銀行口座画面を表示
     */
    public function bank()
    {
        return view('sale.application.bank');
    }

    /**
     * 振込申請確認画面を表示
     */
    public function confirm()
    {
        return view('sale.application.confirm');
    }

    /**
     * 振込申請完了画面を表示
     */
    public function complete()
    {
        return view('sale.application.complete');
    }

    /**
     * 振込申請履歴画面を表示
     */
    public function applicationHistory()
    {
        return view('sale.application.history');
    }


}
