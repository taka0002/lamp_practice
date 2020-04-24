<?php
//設定ファイルを読み込み
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

session_start();

//セッション変数からログイン済みか確認
if(is_logined() === false){
  //login.phpにリダイレクト
  redirect_to(LOGIN_URL);
}
//DB接続
$db = get_db_connect();

//ユーザーidを条件にしてuser_id、name、password、typeをselect
$user = get_login_user($db);

//$user['type']がUSER_TYPE_ADMIN(1)ではないとき
if(is_admin($user) === false){
  //login.phpにリダイレクト
  redirect_to(LOGIN_URL);
}
//postで受け取ったitem_idを定義
$item_id = get_post('item_id');

//postで受け取ったchanges_toを定義
$stock = get_post('stock');

//データベースのitem_idのstockがアップデートされたとき
if(update_item_stock($db, $item_id, $stock)){
  //メッセージ表示
  set_message('在庫数を変更しました。');
} else {
  //エラーメッセージ表示
  set_error('在庫数の変更に失敗しました。');
}
//管理画面へリダイレクト
redirect_to(ADMIN_URL);