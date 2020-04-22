<?php
//設定ファイルを読み込み
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';

session_start();

//セッション変数からログイン済みか確認
if(is_logined() === true){
  //login.phpにリダイレクト
  redirect_to(HOME_URL);
}
//postで受け取ったnameを定義
$name = get_post('name');
//postで受け取ったpasswordを定義
$password = get_post('password');
//データベースに接続
$db = get_db_connect();

//nameで条件を指定したユーザー情報を取得したものを定義
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

//$userのtypeが USER_TYPE_ADMIN(1)のとき
if ($user['type'] === USER_TYPE_ADMIN){
  //管理画面でリダイレクト
  redirect_to(ADMIN_URL);
}
//ホーム画面へリダイレクト
redirect_to(HOME_URL);