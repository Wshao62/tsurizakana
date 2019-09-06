@extends('layouts.app')

@section('title', '領収証')
@section('page_id', 'page_receipt')
@section('css', 'mypage.css')
@section('not_need_head_img', true)

@section('content')
    @include('parts/template_mypage_header', ['current' => 'receipt'])
    <div class="layout mp_cont">
        @if (!empty($receipt))
            @foreach ($receipt as $year => $receipts)
            <table>
                  <tr>
                    <th><p>{{ $year }}年領収証一覧<span class="rece_desc pc">※リンクを押すとPDFをダウンロード出来ます。</span></p><p class="rece_desc sp">※リンクを押すとPDFをダウンロード出来ます。</p></th>
                  </tr>
                  @foreach ($receipts as $months => $date)
                  <tr>
                    <td><a href="{{route('receipt.pdf', $months)}}">{{ $months }}分領収証ダウンロード</a></td>
                  </tr>
                  @endforeach
            </table>
            @endforeach
        @else
            <div class="content_success_box">
                <p class="success">
                    購入履歴が見つかりません。
                </p>
            </div>
        @endif
    </div>
    </div>
@endsection

@section('before_end')
<script>
</script>
@endsection
