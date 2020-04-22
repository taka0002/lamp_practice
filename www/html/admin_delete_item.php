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

//ユーザーidを条件にしてuser_id、name、password、typeをselectしたものを定義
$user = get_login_user($db);

//$user['type']がUSER_TYPE_ADMIN(1)ではないとき
if(is_admin($user) === false){
  //login.phpにリダイレクト
  redirect_to(LOGIN_URL);
}

//postで受け取ったitem_idを定義
$item_id = get_post('item_id');

//destory_itemの返り値がtrueだったときトランザクションでitemsテーブルからアイテムと画像を削除
if(destroy_item($db, $item_id) === true){
  //メッセージ表示
  set_message('商品を削除しました。');
} else {
  //エラーメッセージ表示
  set_error('商品削除に失敗しました。');
}


//管理画面へリダイレクト
redirect_to(ADMIN_URL);