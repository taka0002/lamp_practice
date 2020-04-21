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

//item_idを取得
$item_id = get_post('item_id');

//cartに追加されたとき
if(add_cart($db,$user['user_id'], $item_id)){
  //メッセージ表示
  set_message('カートに商品を追加しました。');
} else {
  //エラーメッセージ表示
  set_error('カートの更新に失敗しました。');
}
//HOME_UR（index.php）Lへリダイレクト
redirect_to(HOME_URL);