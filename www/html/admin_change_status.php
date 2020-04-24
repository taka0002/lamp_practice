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
$changes_to = get_post('changes_to');

//changes_toの情報が"open"だったとき（商品をweb上に公開するかどうか）
if($changes_to === 'open'){
  //$item_idが”ITEM_STATUS_OPEN(1)”
  update_item_status($db, $item_id, ITEM_STATUS_OPEN);
  //メッセージ表示
  set_message('ステータスを変更しました。');

//changes_toの情報が"close"だったとき（商品をweb上に公開するかどうか）
}else if($changes_to === 'close'){
  //$item_idが”ITEM_STATUS_CLOSE(0)”
  update_item_status($db, $item_id, ITEM_STATUS_CLOSE);
  //メッセージ表示
  set_message('ステータスを変更しました。');
}else {
  //エラーメッセージ表示s
  set_error('不正なリクエストです。');
}

//管理画面にリダイレクト
redirect_to(ADMIN_URL);