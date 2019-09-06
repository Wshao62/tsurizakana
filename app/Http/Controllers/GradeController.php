<?php

namespace App\Http\Controllers;

use App\Models\UserRating;
use App\Models\User;
use App\Models\Fish;

class GradeController extends Controller
{
    protected $parameter;

    public function lists(User $user)
    {
        $this->parameter = $this->getParam();

        if ($this->parameter === NULL) {
            abort(403);
        }

        $userInfo = $user;
        $rateList = $this->getRateList($user);
        $dataInfo['current'] = $this->parameter;

        return view('grade.list',[
                        'user' => $userInfo,
                        'rateList' => $rateList,
                        'dataInfo' => $dataInfo
        ]);
    }

    public function getRateList($data)
    {
        $search_joint = array('user_ratings','user_photos' );
        $query = $this->JoinTable($data, $search_joint);

        $data = $query->paginate(5);
        return $data;
    }

    public function JoinTable($data, $entities)
    {
        $query = New User;
        $basetable = 'users';
        $rateArray =  array(
            UserRating::GOOD,
            UserRating::NORMAL,
            UserRating::BAD
        );

        $index = array_search($this->parameter, $rateArray);

        if($index !== false){
            $return = array_slice($rateArray, $index, 1);
            $rateArray = $return;
        }

        $all = "$basetable.*";
        $select = array($all);

        for($i = 0; $i < count($entities); $i++){
            $fields = array();
            $entity = strtolower($entities[$i]);
            $jointTable = $entity;

            switch($entity){
                case 'user_ratings':
                    $query = $query->join("$jointTable", function($join) use($basetable, $data, $rateArray){
                        $join->on("source_user_id",'=', "$basetable.id")
                            ->where('target_user_id', '=', $data->id);

                        $join = $join->whereIn('rate',$rateArray);
                    });

                    $fields = array(
                        \DB::raw("DATE_FORMAT($jointTable.created_at, '%Y/%m/%d') as rDate"),
                        "$jointTable.rate as rate",
                        "$jointTable.comment as comment",
                        "$jointTable.target_user_id as target_user_id",
                        "$jointTable.source_user_id as source_user_id"
                    );
                    break;
                case 'user_photos':
                    $query = $query->leftJoin("$jointTable","$jointTable.user_id","$basetable.id");

                    $fields = array(
                        \DB::raw("COALESCE($jointTable.profile_photo, \"". url(config('const.profile_img_default_icon')). "\") as user_photo")
                    );
                    break;
            }
            $select = array_merge($select,$fields);
        }

        $query = $query->select($select)->orderBy('user_ratings.created_at', 'DESC');

        return $query;
    }

    public function getParam()
    {
        $uri = $_SERVER["REQUEST_URI"];
        $param = explode('/',$uri)[count(explode('/',$uri))-1];
        $param = explode('?',$param)[0];

        if($param === 'good')
        {
            return UserRating::GOOD;
        }
        elseif($param === 'normal')
        {
            return UserRating::NORMAL;
        }
        elseif($param === 'bad')
        {
            return UserRating::BAD;
        }
        else
        {
            return UserRating::ALL;
        }
    }
}