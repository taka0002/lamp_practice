<?php
//設定ファイルを読み込み
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';

session_start();

//ログインがfalseだったとき
if(is_logined() === false){
  //login_URLにリダイレクト
  redirect_to(LOGIN_URL);
}

//postで受け取ったcsrf_tokenを定義
$token = get_post("csrf_token");

//postで受け取った値とセッション変数で受け取った値が一致しているかチェックする必要がある
if(is_valid_csrf_token($token) === FALSE) {

  redirect_to(LOGIN_URL);

}
set_session('csrf_token', '');

//DB接続
$db = get_db_connect();
//ユーザーの一覧を取得
$user = get_login_user($db);

//cart_idの一覧を取得
$carts = get_user_carts($db, $user['user_id']);

//購入ボタンを押したときにfalseだった場合
if(purchase_carts($db, $carts) === false){
  //エラーメッセージ表示
  set_error('商品が購入できませんでした。');
  //cartページにリダイレクト
  redirect_to(CART_URL);
} 


$total_price = sum_carts($carts);


//外部ファイル(/cart_view.php)がすでに読み込まれているか、チェック（1回目は正常に読み込むが、2回目以降は読み込まない）
include_once '../view/finish_view.php';

?>