<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\CreateUser;
use Tests\Traits\CreateBlog;

class BlogTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;
    use CreateUser;
    use CreateBlog;

//======================================================================
    //共通
    /**
    * 未ログイン
    * 2 tests
    * @param  string $base_url 元URL
    * @param  string $redirect_url URLリダイレクト先
    * @dataProvider dataProviderLogin
    */
    public function testBlogNotLogin($base_url, $redirect_url)
    {
        //ユーザーの生成
        $user = $this->createUser();
        //ブログ作成
        $blog = $this->createBlog();

        $this->get(url($base_url))
            ->assertRedirect(url($redirect_url));
    }

    /*
    * 未ログインのデータプロバイダ
    */
    public function dataProviderLogin()
    {
        return [
              //mypage
              'OK /mypage/blog' => ['/mypage/blog', '/login'],
              'OK /mypage/blog/add' => ['/mypage/blog/add', '/login'],
        ];
    }

//======================================================================
    //ブログ一覧
    /**
    * 正常系
    * 1 tests
    */
    public function testBlogList()
    {

        //ユーザーの生成
        $user = $this->createUser();
        //ブログ作成
        $blog = $this->createBlog();

        $base_url = '/user/'. $user->id;
        $this->get(url($base_url))
             ->assertOK();
    }

    /**
    * 存在しないユーザーのブログ一覧
    * 1 tests
    */
    public function testBlogErrorList()
    {

        //ユーザーの生成
        $user = $this->createUser();
        //ブログ作成
        $blog = $this->createBlog();

        //存在しないUser ID
        $base_url = '/user/'. 100;
        $this->get(url($base_url))
             ->assertNotFound();
    }

//======================================================================
    /*
    * ブログ詳細
    * 1 tests
    */
    public function testBlogDetail()
    {
          //ユーザーの生成
          $user = $this->createUser();
          //ブログ作成
          $blog = $this->createBlog();

          $base_url = '/blog/'. $blog->id;
          $this->get(url($base_url))
               ->assertOK();
    }

    /*
    * 存在しないブログ
    * 1 tests
    */
    public function testBlogErrorDetail()
    {
          //ユーザーの生成
          $user = $this->createUser();
          //ブログ作成
          $blog = $this->createBlog();
          //存在しないBlog ID
          $base_url = '/blog/'. 100;
          $this->get(url($base_url))
               ->assertNotFound();
    }

//======================================================================
    /*
    * ブログ管理
    * 1 tests
    */
    public function testBlogAdmin()
    {
          //ユーザーの生成
          $user = $this->createUser();
          //ブログ作成
          $blog = $this->createBlog();

          //作成したユーザーでログイン
          $user_res = $this->actingAs($user, 'user')
                      ->get('/login');

          $base_url = '/mypage/blog';
          $this->get(url($base_url))
               ->assertOK();
    }


//======================================================================
    /*
    * ブログ作成アクセス
    * 1 tests
    */
    public function testLoginBlogAdd()
    {
          //ユーザーの生成
          $user = $this->createUser();
          //作成したユーザーでログイン
          $user_res = $this->actingAs($user, 'user')
                      ->get('/login');

          $base_url = '/mypage/blog/add';
          $this->get(url($base_url))
               ->assertOK();
    }
    /**
    * ブログ作成
    * 2 tests
    * @param  string $base_url 元URL
    * @param  string $redirect_url URLリダイレクト先
    * @param  string data request用
    * @dataProvider dataproviderAdd
    */
    public function testBlogAdd($base_url, $redirect_url, $data)
    {
          //ユーザーIDの生成?
          $user = $this->createUser();

          //作成したユーザーでログイン
          $user_res = $this->actingAs($user, 'user')
                      ->get('/login');

          $this->withHeaders([
            'HTTP_REFERER' => url($base_url),
          ])
          ->post('/mypage/blog/create', $data)
          ->assertRedirect(url($redirect_url))
          ->assertSessionHasNoErrors(['title'])
          ->assertSessionHasNoErrors(['photo'])
          ->assertSessionHasNoErrors(['description'])
          ->assertSessionHasNoErrors(['status']);
    }

    public function dataproviderAdd()
    {
          $faker = \Faker\Factory::create('ja_JP');
          //テスト用画像の生成
          $photo = UploadedFile::fake()->image('img1.jpg', 300, 400)->size(1000);
          $data = [
            'title' => $faker->name,
            'photo' => [$photo],
            'description' => $faker->realText(200),
            'status' => 1,
          ];

          return [
              '[OK] BlogCreate ' => ['/mypage/blog/add', '/mypage/blog/add'.'#created', $data],
          ];
    }
//======================================================================
    /*
    * 更新
    */
    /*
    * ブログ編集ログイン
    * 1 tests
    */
    public function testLoginBlogEdit()
    {
          //ユーザーの生成
          $user = $this->createUser();

          //ブログ作成
          $blog = $this->createBlog();

          //作成したユーザーでログイン
          $user_res = $this->actingAs($user, 'user')
                      ->get('/login');

          $base_url = '/mypage/blog/'. $blog->id .'/edit';
          $this->get(url($base_url))
                ->assertSee($blog->title)
                ->assertSee($blog->description)
                ->assertOK();
    }
    // /**
    // * ブログ編集
    // * 2 tests
    // * @param  string $base_url 元URL
    // * @param  string $redirect_url URLリダイレクト先
    // * @param  string data request用
    // * @dataProvider dataproviderEdit
    // */
    // public function testBlogEdit($data)
    // {
    //       //ユーザーIDの生成?
    //       $user = $this->createUser();
    //
    //       //ブログ作成
    //       $blog = $this->createBlog();
    //
    //       //作成したユーザーでログイン
    //       $user_res = $this->actingAs($user, 'user')
    //                   ->get('/login');
    //
    //       $base_url = '/mypage/blog/'. $blog->id .'/edit';
    //       $redirect_url = '/mypage/blog/'. $blog->id .'/edit'. '#created';
    //       $this->withHeaders([
    //             'HTTP_REFERER' => url($base_url),
    //           ])
    //           ->post('/mypage/blog/updata/'. $blog->id, $data)
    //           ->assertRedirect(url($redirect_url))
    //           ->assertSessionHasNoErrors(['title'])
    //           ->assertSessionHasNoErrors(['photo'])
    //           ->assertSessionHasNoErrors(['description'])
    //           ->assertSessionHasNoErrors(['status']);
    // }
    //
    // public function dataproviderEdit()
    // {
    //       $faker = \Faker\Factory::create('ja_JP');
    //       //テスト用画像の生成
    //       $photo = UploadedFile::fake()->image('img1.jpg', 300, 400)->size(1000);
    //       $data = [
    //         'title' => $faker->name,
    //         'photo' => [$photo],
    //         'description' => $faker->realText(200),
    //         'status' => 1,
    //       ];
    //
    //       return [
    //           '[OK] BlogUpdate ' => [$data],
    //       ];
    // }
//======================================================================
}
