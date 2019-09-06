<?php

namespace Tests\Traits;

use App\Models\Blog;
use App\Models\Blog\Photo;

use Illuminate\Support\Collection;

// 以下の記事より流用
// https://qiita.com/nunulk/items/06370af1594a10faa749
trait CreateBlog
{
    private function createBlog(string $scenario = 'default', array $attributes = []): Blog
    {
        $attributes = collect($attributes);
        $blog = factory(Blog::class, $scenario)->create($attributes->get('blog', []));
        return $this->buildBlog($blog, $scenario, $attributes);
    }

    private function buildBlog(Blog $blog, string $scenario, Collection $attributes): Blog
    {
        //関連モデルなどが出てきた場合にこちらで以下のように定義できる
        $blog->photos()->save(factory(Photo::class, $scenario)->make(['blog_id' => $blog->id,]));
        return $blog;
    }
}
