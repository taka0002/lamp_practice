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
//postで受け取ったpassword_confirmationを定義
$password_confirmation = get_post('password_confirmation');
//db接続
$db = get_db_connect();

try{
  //regist_user関数を定義(nameとpasswordが規定内のものになっている)
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
//nameを条件にしたユーザー情報をselect
login_as($db, $name, $password);
//index.phpへリダイレクト
redirect_to(HOME_URL);