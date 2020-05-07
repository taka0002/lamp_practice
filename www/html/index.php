<?php
//設定ファイルを読み込み
require_once '../conf/const.php';
require_once '../model/functions.php';
require_once '../model/user.php';
require_once '../model/item.php';

session_start();

//セッション変数からログイン済みか確認
if(is_logined() === false){
  //login.phpにリダイレクト
  redirect_to(LOGIN_URL);
}

//DB接続
$db = get_db_connect();

//ユーザーidを条件にしてuser_id、name、password、typeをselectしたものを定義
$user = get_login_user($db);

//statusが1のitemsの商品をselectしたものを定義
$items = get_open_items($db);

//index.phpに表示される商品数を数える
$items_num = count($items);

$max_page = ceil($items_num / MAX);

if(get_get('page_id')) {
  $now = $_GET['page_id'];
} else {
  // 設定されてない場合は1ページ目にする
  $now = 1;
}

$start_no = ($now - 1) * MAX;

//配列の一部を切り取ってindex.phpに表示させる(page_idが2なら、9件目の要素を開始位置とする。つまりは、1〜8件までを切り取る）第4引数にtrueを指定した場合、元の配列の添字を維持
$disp_data = array_slice($items, $start_no, MAX, true);

//index.phpに表示されている商品数をカウント
$count = count($disp_data);

//件数の数の表示（$page_fin）とセット
$page_ini = ($start_no + 1);

//件数の数の表示（$page_ini）とセット
if($count === 8) {
  $page_fin = ($start_no + 8);
} else {
  $page_fin = $items_num;
}

//トークンの作成
$token = get_csrf_token();

//外部ファイル(/index_view.php)がすでに読み込まれているか、チェック（1回目は正常に読み込むが、2回目以降は読み込まない）
include_once VIEW_PATH . 'index_view.php';