<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Traits\CreateUser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Mockery;
use \App\Models\Fish;
use \App\Models\Fish\Category;
use \App\Models\Fish\Photo;
use Illuminate\Http\UploadedFile;

class FishTest extends TestCase
{
    use DatabaseMigrations;
    use CreateUser;

    protected $user;
    protected $input_data = null;

    protected $fish_model_mock;

    protected $fish;
    protected $category;
    protected $photo;

    /**
     * ログインしているユーザに対して入力フォームが表示されること
     */
    public function testShowCreateFormSuccess()
    {
        $this->prepareLoginUser();

        $this->get('/mypage/fish/add')
            ->assertOK();
    }

    /**
     * フォームはログインしていないユーザに対してはログイン画面へリダイレクトすること
     */
    public function testCreateFormRedirect4UserNotLogined()
    {
        $this->get('/mypage/fish/add')
        ->assertRedirect('/login');
    }

    /**
     * 確認画面から戻ってきても値が保持されたままとなること
     */
    public function testCreateFormValuesNotLost()
    {
        $this->prepareLoginUser();
        $this->prepareFishInputData();

        $this->withSession(['fish_data' => $this->input_data])
        ->get('/mypage/fish/add')
        ->assertSee('"fish_category_name" value="'.$this->input_data['fish_category_name'].'"')
        ->assertSee('"location" value="'.$this->input_data['location'].'"')
        ->assertSee('"price" value="'.$this->input_data['price'].'"')
        ->assertSee('"description">'.$this->input_data['description'].'<');
    }

    /**
     * 確認画面で送信したデータが正しく表示されていること
     */
    public function testCreateConfirmPageSuccess()
    {
        $this->prepareLoginUser();
        $this->prepareFishInputData();

        $this->input_data['_token'] = csrf_token();
        $photo = UploadedFile::fake()->image('img1.jpg', 300, 400)->size(1000);
        $this->input_data['photo'] = [$photo];
        $response = $this->post('/mypage/fish/confirm', $this->input_data);

        $this->input_data['photo'] = [[
                            'tmp_path' => $photo->path(),
                            'mime' => $photo->getClientMimeType(),
                        ]];

        $response->assertSessionHasAll(['fish_data' => $this->input_data])
                ->assertSee($this->input_data['fish_category_name'])
                ->assertSee($this->input_data['location'])
                ->assertSee($this->input_data['price'])
                ->assertSee($this->input_data['description']);
    }

    /**
     * フォームで入力された値が正しくDBに挿入されること
     */
    public function testCreateDataSuccess()
    {
        $this->prepareLoginUser();

        $this->prepareFishInputData();
        $this->input_data['_token'] = csrf_token();
        $photo = UploadedFile::fake()->image('img1.jpg', 300, 400)->size(1000);
        $this->input_data['photo'] = [
            [
                'tmp_path' => $photo->path(),
                'mime' => $photo->getClientMimeType(),
            ],
        ];

        $this->withSession(['fish_data' => $this->input_data])
            ->post('/mypage/fish/complete')
            ->assertOK()
            ->assertSessionMissing('fish_data');

        $fish_cnt = Fish::count();
        $this->assertEquals(1, $fish_cnt);

        $cate_cnt = Category::count();
        $this->assertEquals(1, $cate_cnt);

        $photo_cnt = Photo::count();
        $this->assertEquals(1, $photo_cnt);
    }

    /**
     * sessionなしで完了画面へpostした際は403であること
     */
    public function testCompleteWithNoSessionRedirect()
    {
        $this->prepareLoginUser();

        $this->post('/mypage/fish/complete')
        ->assertRedirect('/mypage/fish/add')
        ->assertSessionHas('error', 'セッション切れか、不正な画面遷移です。再度入力して手続きを進めて下さい。');
    }

    /**
     *  データ挿入中にエラーとなった場合は入力画面へリダイレクトし、エラーが表示されること
     */
    public function testCreateCompleteErrorsRedirect()
    {
        $this->prepareLoginUser();

        $this->prepareFishInputData();
        $this->input_data['_token'] = csrf_token();
        $photo = UploadedFile::fake()->image('img1.jpg', 300, 400)->size(1000);
        $this->input_data['photo'] = [
            [
                'tmp_path' => $photo->path(),
                'mime' => $photo->getClientMimeType(),
            ],
        ];

        //モック作成
        $mock = Mockery::mock(Fish::class)->makePartial();
        $mock->shouldReceive('register')
            ->once()
            ->andReturn(false);
        $this->instance(Fish::class, $mock);

        $this->withSession(['fish_data' => $this->input_data])
            ->post('/mypage/fish/complete')
            ->assertRedirect('/mypage/fish/add')
            ->assertSessionHas('error', 'システムエラーが発生しました。しばらく待ってから再度お試しください。それでも失敗する場合はお問い合わせください。');
        //TODO: エラーのconst書き出し
    }

    /**
     *  データ挿入中にエラーとなった場合は入力画面へリダイレクトし、エラーが表示されること
     */
    public function testUpdateFormShow()
    {
        $this->prepareLoginUser();

        $category = factory(Category::class)->create()->toArray();

        $this->prepareFishDataOnDatabase();

        $this->prepareFishInputData();

        $this->get('/mypage/fish/'.$this->fish['id'].'/edit')
            ->assertSee('"fish_category_name" value="'.$this->fish['fish_category_name'].'"')
            ->assertSee('"location" value="'.$this->fish['location'].'"')
            ->assertSee('"price" value="'.$this->fish['price'].'"')
            ->assertSee('"description">'.$this->fish['description'].'<');
    }

    /**
     * 他人の魚編集フォームは表示されないこと
     */
    public function testUpdateFormNotShow4OtherUser()
    {
        $this->prepareLoginUser();

        $this->prepareFishDataOnDatabase(['seller_id' => 666]);
        $this->get('/mypage/fish/'.$this->fish['id'].'/edit')
        ->assertStatus(403);
    }

    /**
     * 編集が正常にできること
     */
    public function testUpdateSuccess()
    {
        $this->prepareLoginUser();

        $this->prepareFishDataOnDatabase();

        $this->prepareFishInputData();
        $this->input_data['_token'] = csrf_token();

        $response = $this->post('/mypage/fish/'.$this->fish['id'].'/edit', $this->input_data)
                    ->assertSessionHas('status', '売魚情報を変更しました。');

        $fish = Fish::find($this->fish['id'])->toArray();
        unset($this->input_data['_token']);
        $this->assertArraySubset($this->input_data, $fish);

        //TODO: 画像が変更でき、前画像が削除されていること modelでtestする？
    }

    /**
     * 詳細ページが表示されること
     */
    public function testFishDetailShow()
    {
        $this->prepareLoginUser();

        $this->prepareFishDataOnDatabase();
        $this->get('/fish/'.$this->fish['id'])
            ->assertOK()
            ->assertSee($this->fish['fish_category_name'])
            ->assertSee($this->fish['location'])
            ->assertSee($this->fish['price'])
            ->assertSee($this->fish['description'])
            ->assertSee($this->user['name']);
    }

    /**
     * カテゴリー検索が正しいjsonで返却されること
     *
     */
    public function testSearchCategory()
    {
        $category = factory(Category::class)->create(['name' => 'あいうえお',])->toArray();

        $this->post('/fish/category', ['keyword' => 'う'])
            ->assertJson(['あいうえお']);
    }

    private function prepareLoginUser()
    {
        $this->user = $this->createUser();
        $this->actingAs($this->user, 'user');
    }

    private function prepareFishInputData()
    {
        $faker = \Faker\Factory::create('ja_JP');
        $this->input_data = [
            'fish_category_name' => mb_substr($faker->realText, 0, rand(1, 30)),
            'location' => $faker->address,
            'price' => rand(100, 10000),
            'description' => $faker->realText,
        ];
    }

    private function prepareFishDataOnDatabase($fish_override = [])
    {
        $this->category = factory(Category::class)->create()->toArray();
        $fish_data = [
                'seller_id' => $this->user['id'],
                'fish_category_name' => $this->category['name'],
                'fish_category_id' => $this->category['id'],
            ];
        $this->fish = factory(Fish::class)->create($fish_override + $fish_data)->toArray();
        $this->photo = factory(Photo::class)->create(['fish_id' => $this->fish['id']])->toArray();
    }
}
