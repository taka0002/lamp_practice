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

//postで受け取ったcart_idを定義
$cart_id = get_post('cart_id');

//cartsテーブルから商品がdeleteされたとき(条件：cart_id)
if(delete_cart($db, $cart_id)){
  //メッセージ表示
  set_message('カートを削除しました。');
} else {
  //エラーメッセージ表示
  set_error('カートの削除に失敗しました。');
}

//カートページへリダイレクト
redirect_to(CART_URL);