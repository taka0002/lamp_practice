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
  //login_URLにリダイレクト
  redirect_to(LOGIN_URL);
}
//item_idの情報をデータベースから返す
$item_id = get_post('item_id');

//changes_toの情報をデータベースから返す
$changes_to = get_post('changes_to');

//changes_toの情報が"open"だったとき（商品をweb上に公開するかどうか）
if($changes_to === 'open'){
  //$item_idが”ITEM_STATUS_OPEN”
  update_item_status($db, $item_id, ITEM_STATUS_OPEN);
  //メッセージ表示
  set_message('ステータスを変更しました。');

//changes_toの情報が"close"だったとき（商品をweb上に公開するかどうか）
}else if($changes_to === 'close'){
  //$item_idが”ITEM_STATUS_CLOSE”
  update_item_status($db, $item_id, ITEM_STATUS_CLOSE);
  //メッセージ表示
  set_message('ステータスを変更しました。');
}else {
  //エラーメッセージ表示
  set_error('不正なリクエストです。');
}


redirect_to(ADMIN_URL);