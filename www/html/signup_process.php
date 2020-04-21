<?php
//設定ファイルを読み込み
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';

session_start();
//ログインがtrueだったとき
if(is_logined() === true){
  //index.phpにリダイレクト
  redirect_to(HOME_URL);
}
//nameを取得
$name = get_post('name');
//passwordを取得
$password = get_post('password');
//passwordの確認
$password_confirmation = get_post('password_confirmation');
//db接続
$db = get_db_connect();

try{
  //regist_userを定義
  $result = regist_user($db, $name, $password, $password_confirmation);

  if( $result=== false){
    set_error('ユーザー登録に失敗しました。');
    //signup_view.phpへリダイレクト
    redirect_to(SIGNUP_URL);
  }
}catch(PDOException $e){
  set_error('ユーザー登録に失敗しました。');
  //signup_view.phpへリダイレクト
  redirect_to(SIGNUP_URL);
}
//メッセージ表示
set_message('ユーザー登録が完了しました。');
//入力されたnameとpasswordでログイン
login_as($db, $name, $password);
//index.phpへリダイレクト
redirect_to(HOME_URL);