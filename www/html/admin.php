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

$items = get_all_items($db);

//外部ファイルがすでに読み込まれているか、チェック（1回目は正常に読み込むが、2回目以降は読み込まない）
include_once VIEW_PATH . '/admin_view.php';
