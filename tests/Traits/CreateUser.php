<?php

namespace Tests\Traits;

use App\Models\User;
use Illuminate\Support\Collection;

// 以下の記事より流用
// https://qiita.com/nunulk/items/06370af1594a10faa749
trait CreateUser
{
    private function createUser(string $scenario = 'default', array $attributes = []): User
    {
        $attributes = collect($attributes);
        $user = factory(User::class, $scenario)->create($attributes->get('user', []));
        return $this->buildUser($user, $scenario, $attributes);
    }

    private function buildUser(User $user, string $scenario, Collection $attributes): User
    {
        //関連モデルなどが出てきた場合にこちらで以下のように定義できる
        // $user->save(factory(UserAttribute::class, $scenario)->create($attributes->get('user_attribute', [])));
        return $user;
    }
}
