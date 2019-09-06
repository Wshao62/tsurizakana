<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Fish\Category;

class FishCategoryTest extends TestCase
{
    // /**
    //  * Fulltext用の文字列が生成されること
    //  */
    // public function testMakeFulltext()
    // {
    //     $str = "abcdefg, hijklmnopqrstu.";
    //     $str_fulltext = "a b c d e f g , h i j k l m n o p q r s t u .";
    //     $rtn = Category::makeFulltext($str);
    //     $this->assertEquals($str_fulltext, $rtn);

    //     $str2 = "あい「うえおかき」くけ、　こさしすせそ。";
    //     $str2_fulltext = "あ い 「 う え お か き 」 く け 、 こ さ し す せ そ 。";
    //     $rtn2 = Category::makeFulltext($str2);
    //     $this->assertEquals($str2_fulltext, $rtn2);
    // }
}
