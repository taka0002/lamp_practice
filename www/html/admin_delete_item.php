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

//dbのitem_idがdestoryされたとき
if(destroy_item($db, $item_id) === true){
  //メッセージ表示
  set_message('商品を削除しました。');
} else {
  //エラーメッセージ表示
  set_error('商品削除に失敗しました。');
}



redirect_to(ADMIN_URL);