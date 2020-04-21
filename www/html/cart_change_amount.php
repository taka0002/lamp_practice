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
//DB接続
$db = get_db_connect();

//ユーザーの一覧を取得
$user = get_login_user($db);
//cart_idの情報をデータベースから返す
$cart_id = get_post('cart_id');
//amountの情報をデータベースから返す
$amount = get_post('amount');

//cart_amountをアップデートしたとき
if(update_cart_amount($db, $cart_id, $amount)){
  //メッセージ表示
  set_message('購入数を更新しました。');
} else {
  //エラーメッセージ表示
  set_error('購入数の更新に失敗しました。');
}

redirect_to(CART_URL);