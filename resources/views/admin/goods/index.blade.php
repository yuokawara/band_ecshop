@extends('layouts.admin')
@section('title', '登録済み商品の一覧')

@section('content')
    <div class="container">
        <div class="row">
            <h2>商品一覧</h2>
        </div>
        <div class="row">
            <div class="col-md-4">
                <a href="{{ action('Admin\GoodsController@add') }}" role="button" class="btn btn-primary">新規作成</a>
            </div>
            <div class="col-md-8">
                <form action="{{ action('Admin\GoodsController@index') }}" method="get">
                    <div class="form-group row">
                        <label class="col-md-2">タイトル</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="cond_title" value="{{ $cond_title }}">
                        </div>
                        <div class="col-md-2">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="検索">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="list-news col-md-12 mx-auto">
                <div class="row">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th width="10%">ID</th>
                                <th width="10%">商品</th>
                                <th width="10%">価格</th>
                                <th width="30%">商品説明</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $goods)
                                <tr>
                                    <th>{{ $goods->id }}</th>
                                    <td>{{ Str::limit($goods->title, 50) }}</td>
                                    <td>{{ Str::limit($goods->price, 50) }}</td>
                                    <td>{{ Str::limit($goods->body, 250) }}</td>
                                    <td>
                                        <div>
                                            <a href="{{ action('Admin\GoodsController@edit', ['id' => $goods->id]) }}">編集</a>
                                        </div>
                                        <div>
                                            <a href="{{ action('Admin\GoodsController@delete', ['id' => $goods->id]) }}">削除</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection