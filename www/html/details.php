<?php
//設定ファイルを読み込み
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';

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
//ユーザーidを条件にして、cartsテーブルにある商品情報を取得したものを定義(itemsテーブルを結合)
$carts = get_user_carts($db, $user['user_id']);
//cartsの合計額を取得したものを定義
$total_price = sum_carts($carts);

//postで受け取ったhistory_idを定義
$history_id = get_post('history_id');

//postで受け取ったcreatedを定義
$created =  get_post('created');

//postで受け取ったtotal_priceを定義
$total_price =  get_post('total_price');

$details = get_details($db, $history_id);

//トークンの作成
$token = get_csrf_token();

//外部ファイル(/cart_view.php)がすでに読み込まれているか、チェック（1回目は正常に読み込むが、2回目以降は読み込まない）
include_once VIEW_PATH . 'details_view.php';

?>