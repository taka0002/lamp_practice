<?php
//設定ファイルを読み込み
require_once '../conf/const.php';
require_once '../model/functions.php';
require_once '../model/user.php';
require_once '../model/item.php';

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

//statusが1のitemsの商品をselectしたものを定義
$items = get_open_items($db);

//トークンの作成
$token = get_csrf_token();

//外部ファイル(/index_view.php)がすでに読み込まれているか、チェック（1回目は正常に読み込むが、2回目以降は読み込まない）
include_once VIEW_PATH . 'index_view.php';