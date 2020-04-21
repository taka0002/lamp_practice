<?php
//設定ファイルを読み込み
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';

session_start();

//ログインがfalseだったとき
if(is_logined() === true){
  //login_URLにリダイレクト
  redirect_to(HOME_URL);
}
//nameを受け取り
$name = get_post('name');
//passwordを受け取り
$password = get_post('password');
//データベースに接続
$db = get_db_connect();

//nameとpasswordでログインした情報を定義
$user = login_as($db, $name, $password);
//ログイン情報が間違っているとき

if( $user === false){
  //エラーメッセージ
  set_error('ログインに失敗しました。');
  //ログインページへリダイレクト
  redirect_to(LOGIN_URL);
}
//ログインしたときのメッセージを表示
set_message('ログインしました。');


if ($user['type'] === USER_TYPE_ADMIN){
  //管理画面でリダイレクト
  redirect_to(ADMIN_URL);
}
//ホーム画面へリダイレクト
redirect_to(HOME_URL);