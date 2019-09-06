<?php
namespace App;

use Illuminate\Support\Facades\File;
use App\Helpers\FileHelper;
use App\Models\User;
use App\Models\Fish;

class CustomValidator extends \Illuminate\Validation\Validator
{
    public function validateFurigana($attribute, $value, $parameters, $validator)
    {
        if (preg_match('/[^ァ-ヴー・ｧ-ﾝﾞﾟ\s]/u', $value) !== 0) {
            return false;
        }
        return true;
    }

    public function validateZipcode($attribute, $value, $parameters, $validator)
    {
        if (preg_match('/^\d{3}\-?\d{4}$/', $value) === 0) {
            return false;
        }
        return true;
    }

    public function validatePhone($attribute, $value, $parameters, $validator)
    {
        $value = preg_replace('/^(0\d+)\-?(\d+)\-?(\d+)/u', '$1$2$3', $value);
        if (preg_match('/^0[0-9]{9,10}$/', $value) === 0) {
            return false;
        }
        return true;
    }

    public function validateActiveStorageUrl($attribute, $value, $parameters, $validator)
    {
        $value = FileHelper::getServerPath($value);
        if (!File::exists($value)) {
            return false;
        }
        return true;
    }

    private $fish = null;
    private $fish_photos =  null;
    public function validateValidFishPhotoId($attribute, $value, $parameters, $validator)
    {
        if (empty($this->fish)) {
            $this->fish = \App\Models\Fish::find($parameters[0]);
        }
        if (empty($this->fish_photos)) {
            $this->fish_photos = $this->fish->photos;
        }
        $ids = $this->fish_photos->pluck('id')->toArray();
        if (!in_array($value, $ids)) {
            return false;
        }
        return true;
    }

    private $blog = null;
    private $blog_photos =  null;
    public function validateValidBlogPhotoId($attribute, $value, $parameters, $validator)
    {
        if (empty($this->blog)) {
            $this->blog = \App\Models\Blog::find($parameters[0]);
        }
        if (empty($this->blog_photos)) {
            $this->blog_photos = $this->blog->photos;
        }
        $ids = $this->blog_photos->pluck('id')->toArray();
        if (!in_array($value, $ids)) {
            return false;
        }
        return true;
    }

    public function validateBankUserName($attribute, $value, $parameters, $validator)
    {
        if (preg_match('/[^ァ-ヴー・ｧ-ﾝﾞﾟ\s\(\)（）0-9０-９]/u', $value) !== 0) {
            return false;
        }
        return true;
    }

    public function validateCanDeleteBank($attribute, $value, $parameters, $validator)
    {
        //DBに元から値が入っている場合、且つ値を削除する場合
        $user_id = $parameters[0];
        if (empty($user_id)) {
            $user = \Auth::user();
        } else {
            $user = User::find($user_id);
        }

        //元から空なら何もしない
        if (empty($user->bank_name)) {
            return true;
        }

        //先月今月で売り上げがあるか
        $from = (new \DateTime('first day of last months'))->format('Y-m-d 00:00:00');
        $to = (new \DateTime('last day of this months'))->format('Y-m-d 23:59:59');
        $order = \DB::table('orders as O')
                ->join('fish as F', function ($qry) {
                    $qry->on('F.id', '=', 'O.item_id');
                })
            ->where('F.seller_id', '=', $user->id)
            ->whereNotNull('O.billed_at')
            ->where('O.billed_at', '>=', \DB::raw('"'. $from. '"'))
            ->where('O.billed_at', '<=', \DB::raw('"'. $to. '"'))
            ->whereNull('O.deleted_at')
            ->exists();

        //取引完了していない魚があるか
        $fish = $user->sale;
        if (!empty($fish)) {
            $fish = $user->sale()->where('status', '>=', Fish::STATUS_PAYING)
            ->where('status', '<=', Fish::STATUS_EVALUATE)
            ->whereNull('deleted_at')
            ->exists();
        }

        if (($order || !empty($fish) || $fish == true) && empty($value)) {
            return false;
        }

        return true;
    }
}
