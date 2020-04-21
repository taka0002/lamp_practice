<?php
//設定ファイルを読み込み
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

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

//リクエストページが管理者ページではないとき
if(is_admin($user) === false){
  //LOGIN＿URLにリダイレクト
  redirect_to(LOGIN_URL);
}
//item_idの情報をデータベースから返す
$item_id = get_post('item_id');

//changes_toの情報をデータベースから返す
$stock = get_post('stock');

//データベースのitem_idのstockがアップデートされたとき
if(update_item_stock($db, $item_id, $stock)){
  //メッセージ表示
  set_message('在庫数を変更しました。');
} else {
  //エラーメッセージ表示
  set_error('在庫数の変更に失敗しました。');
}

redirect_to(ADMIN_URL);