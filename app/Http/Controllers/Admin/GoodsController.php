<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// 以下を追記することでNews Modelが扱えるようになる
use App\Goods;
use App\History;
use Carbon\Carbon;

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

  public function edit(Request $request)
  {
      // Goods Modelからデータを取得する
      $goods = Goods::find($request->id);
      if (empty($goods)) {
        abort(404);    
      }
      return view('admin.goods.edit', ['goods_form' => $goods]);
  }


  public function update(Request $request)
  {
      // Validationをかける
      $this->validate($request, Goods::$rules);
      // Goods Modelからデータを取得する
      $goods = Goods::find($request->id);
      // 送信されてきたフォームデータを格納する
      $goods_form = $request->all();
      if (isset($goods_form['image'])) {
        $path = $request->file('image')->store('public/image');
        $goods->image_path = basename($path);
        unset($goods_form['image']);
      } elseif (0 == strcmp($request->remove, 'true')) {
        $goods->image_path = null;
      }
      unset($goods_form['_token']);
      unset($goods_form['remove']);

      // 該当するデータを上書きして保存する
      $goods->fill($goods_form)->save();
      // 以下を追記
      $history = new History;
      $history->goods_id = $goods->id;
      $history->edited_at = Carbon::now();
      $history->save();

      return redirect('admin/goods');
  }
  // 以下を追記　　
  public function delete(Request $request)
  {
      // 該当するNews Modelを取得
      $goods = Goods::find($request->id);
      // 削除する
      $goods->delete();
      return redirect('admin/goods/');
  }  
}