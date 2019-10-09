@extends('layouts.app')

@section('title', '売上履歴')
@section('page_id', 'page_salesHistory')
@section('css', 'mypage.css')
@section('not_need_head_img', true)

@section('content')
    @include('parts/template_mypage_header', ['current' => 'sales'])
    <div class="sales_cont">
        <div class="sales_tabs">
            <a href="{{ url('mypage/sales') }}">売上金</a>
            <a href="{{ url('mypage/sales/history') }}" class="current">売上履歴</a>
            <a href="{{ url('mypage/sales/application') }}">振込申請</a>
            <a href="{{ url('mypage/sales/application/history') }}">申請履歴</a>
        </div><!-- END sales_tabs -->
        <div class="saleslists_cont">
            <p>（全00件中）1〜12件表示</p>
            <table class="saleslists_table">
                <thead>
                <tr>
                    <th class="cell_productName">商品名</th>
                    <th class="cell_saleTo">販売先</th>
                    <th class="cell_saleDate">販売日</th>
                    <th class="cell_salePrice">販売代金</th>
                </tr>
                </thead><!-- END thead -->
                <tbody>
                <tr>
                    <th>商品名</th>
                    <td class="cell_productName">
                        <div class="fit_image">
                            <img src="../../img/fish/buy_fish1.jpg">
                        </div>
                        <span>商品名が入ります</span>
                    </td>
                    <th>販売先</th>
                    <td class="cell_saleTo">ユーザー名が入ります</td>
                    <th>販売日</th>
                    <td class="cell_saleDate">2019/01/01</td>
                    <th>販売代金</th>
                    <td class="cell_salePrice">10,000円</td>
                </tr><!-- END tr -->
                <tr>
                    <th>商品名</th>
                    <td class="cell_productName">
                        <div class="fit_image">
                            <img src="../../img/fish/buy_fish1.jpg">
                        </div>
                        <span>商品名が入ります</span>
                    </td>
                    <th>販売先</th>
                    <td class="cell_saleTo">ユーザー名が入ります</td>
                    <th>販売日</th>
                    <td class="cell_saleDate">2019/01/01</td>
                    <th>販売代金</th>
                    <td class="cell_salePrice">10,000円</td>
                </tr><!-- END tr -->
                <tr>
                    <th>商品名</th>
                    <td class="cell_productName">
                        <div class="fit_image">
                            <img src="../../img/fish/selled_fish3.jpg">
                        </div>
                        <span>商品名が入ります</span>
                    </td>
                    <th>販売先</th>
                    <td class="cell_saleTo">ユーザー名が入ります</td>
                    <th>販売日</th>
                    <td class="cell_saleDate">2019/01/01</td>
                    <th>販売代金</th>
                    <td class="cell_salePrice">10,000円</td>
                </tr><!-- END tr -->
                <tr>
                    <th>商品名</th>
                    <td class="cell_productName">
                        <div class="fit_image">
                            <img src="../../img/fish/buy_fish2.jpg">
                        </div>
                        <span>商品名が入ります</span>
                    </td>
                    <th>販売先</th>
                    <td class="cell_saleTo">ユーザー名が入ります</td>
                    <th>販売日</th>
                    <td class="cell_saleDate">2019/01/01</td>
                    <th>販売代金</th>
                    <td class="cell_salePrice">10,000円</td>
                </tr><!-- END tr -->
                <tr>
                    <th>商品名</th>
                    <td class="cell_productName">
                        <div class="fit_image">
                            <img src="../../img/fish/selled_fish3.jpg">
                        </div>
                        <span>商品名が入ります</span>
                    </td>
                    <th>販売先</th>
                    <td class="cell_saleTo">ユーザー名が入ります</td>
                    <th>販売日</th>
                    <td class="cell_saleDate">2019/01/01</td>
                    <th>販売代金</th>
                    <td class="cell_salePrice">10,000円</td>
                </tr><!-- END tr -->
                <tr>
                    <th>商品名</th>
                    <td class="cell_productName">
                        <div class="fit_image">
                            <img src="../../img/fish/buy_fish2.jpg">
                        </div>
                        <span>商品名が入ります</span>
                    </td>
                    <th>販売先</th>
                    <td class="cell_saleTo">ユーザー名が入ります</td>
                    <th>販売日</th>
                    <td class="cell_saleDate">2019/01/01</td>
                    <th>販売代金</th>
                    <td class="cell_salePrice">10,000円</td>
                </tr><!-- END tr -->
                <tr>
                    <th>商品名</th>
                    <td class="cell_productName">
                        <div class="fit_image">
                            <img src="../../img/fish/selled_fish3.jpg">
                        </div>
                        <span>商品名が入ります</span>
                    </td>
                    <th>販売先</th>
                    <td class="cell_saleTo">ユーザー名が入ります</td>
                    <th>販売日</th>
                    <td class="cell_saleDate">2019/01/01</td>
                    <th>販売代金</th>
                    <td class="cell_salePrice">10,000円</td>
                </tr><!-- END tr -->
                <tr>
                    <th>商品名</th>
                    <td class="cell_productName">
                        <div class="fit_image">
                            <img src="../../img/fish/buy_fish1.jpg">
                        </div>
                        <span>商品名が入ります</span>
                    </td>
                    <th>販売先</th>
                    <td class="cell_saleTo">ユーザー名が入ります</td>
                    <th>販売日</th>
                    <td class="cell_saleDate">2019/01/01</td>
                    <th>販売代金</th>
                    <td class="cell_salePrice">10,000円</td>
                </tr><!-- END tr -->
                <tr>
                    <th>商品名</th>
                    <td class="cell_productName">
                        <div class="fit_image">
                            <img src="../../img/fish/selled_fish3.jpg">
                        </div>
                        <span>商品名が入ります</span>
                    </td>
                    <th>販売先</th>
                    <td class="cell_saleTo">ユーザー名が入ります</td>
                    <th>販売日</th>
                    <td class="cell_saleDate">2019/01/01</td>
                    <th>販売代金</th>
                    <td class="cell_salePrice">10,000円</td>
                </tr><!-- END tr -->
                <tr>
                    <th>商品名</th>
                    <td class="cell_productName">
                        <div class="fit_image">
                            <img src="../../img/fish/buy_fish1.jpg">
                        </div>
                        <span>商品名が入ります</span>
                    </td>
                    <th>販売先</th>
                    <td class="cell_saleTo">ユーザー名が入ります</td>
                    <th>販売日</th>
                    <td class="cell_saleDate">2019/01/01</td>
                    <th>販売代金</th>
                    <td class="cell_salePrice">10,000円</td>
                </tr><!-- END tr -->
                <tr>
                    <th>商品名</th>
                    <td class="cell_productName">
                        <div class="fit_image">
                            <img src="../../img/fish/buy_fish2.jpg">
                        </div>
                        <span>商品名が入ります</span>
                    </td>
                    <th>販売先</th>
                    <td class="cell_saleTo">ユーザー名が入ります</td>
                    <th>販売日</th>
                    <td class="cell_saleDate">2019/01/01</td>
                    <th>販売代金</th>
                    <td class="cell_salePrice">10,000円</td>
                </tr><!-- END tr -->
                <tr>
                    <th>商品名</th>
                    <td class="cell_productName">
                        <div class="fit_image">
                            <img src="../../img/fish/buy_fish2.jpg">
                        </div>
                        <span>商品名が入ります</span>
                    </td>
                    <th>販売先</th>
                    <td class="cell_saleTo">ユーザー名が入ります</td>
                    <th>販売日</th>
                    <td class="cell_saleDate">2019/01/01</td>
                    <th>販売代金</th>
                    <td class="cell_salePrice">10,000円</td>
                </tr><!-- END tr -->
                </tbody><!-- END tbody -->
            </table><!-- END saleslists_table -->
            <div class="pager font_avenirnext">
                <p class="current"><span>1</span></p>
                <p><a href="#"><span>2</span></a></p>
                <p><a href="#"><span>3</span></a></p>
                <p><a href="#"><span>4</span></a></p>
                <p><a href="#"><span>5</span></a></p>
                <p><a href="#"><span>6</span></a></p>
                <p><a href="#"><span>7</span></a></p>
                <p><a href="#"><span>8</span></a></p>
                <p><a href="#"><span>9</span></a></p>
                <p><a href="#"><span>10</span></a></p>
                <p><a href="#"><span>11</span></a></p>
                <p><a href="#"><span>12</span></a></p>
                <p><a href="#"><span>13</span></a></p>
                <p><a href="#"><span>14</span></a></p>
                <p><a href="#"><span>15</span></a></p>
                <p><a href="#"><span>16</span></a></p>
                <p><a href="#"><span>17</span></a></p>
                <p><a href="#"><span>18</span></a></p>
                <p><a href="#"><span>19</span></a></p>
                <p><a href="#"><span>20</span></a></p>
                <p><a href="#"><span>21</span></a></p>
                <p><a href="#"><span>22</span></a></p>
                <p><a href="#"><span>23</span></a></p>
                <p><a href="#"><span>24</span></a></p>
                <p><a href="#"><span>25</span></a></p>
                <p><a href="#"><span>26</span></a></p>
                <p><a href="#"><span>27</span></a></p>
                <p><a href="#"><span>28</span></a></p>
                <p><a href="#"><span>29</span></a></p>
                <p><a href="#"><span>30</span></a></p>
                <p><a href="#"><span>31</span></a></p>
                <p><a href="#"><span>32</span></a></p>
            </div><!-- END pager -->
        </div><!-- END saleslists_cont -->
    </div><!-- END sales_cont -->
    </div><!-- END mp_cont -->
@endsection

@section('before_end')
    <script>
    </script>
    <link rel="stylesheet" href="{{ url('css') }}/sales.css">
@endsection
