<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// 以下を追記することでNews Modelが扱えるようになる
use App\Goods;

class GoodsController extends Controller
{
  public function add()
  {
      return view('admin.goods.create');
  }

  public function create(Request $request)
  {

      // 以下を追記
      // Varidationを行う
      $this->validate($request, Goods::$rules);

      $goods = new Goods;
      $form = $request->all();

      // フォームから画像が送信されてきたら、保存して、$goods->image_path に画像のパスを保存する
      if (isset($form['image'])) {
        $path = $request->file('image')->store('public/image');
        $goods->image_path = basename($path);
      } else {
          $goods->image_path = null;
      }

      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);
      // フォームから送信されてきたimageを削除する
      unset($form['image']);

      // データベースに保存する
      $goods->fill($form);
      $goods->save();

      return redirect('admin/goods/create');
  }
// 以下を追記
  public function index(Request $request)
  {
      $cond_title = $request->cond_title;
      if ($cond_title != '') {
          // 検索されたら検索結果を取得する
          $posts = Goods::where('title', $cond_title)->get();
      } else {
          // それ以外はすべてのニュースを取得する
          $posts = Goods::all();
      }
      return view('admin.goods.index', ['posts' => $posts, 'cond_title' => $cond_title]);
  }
}