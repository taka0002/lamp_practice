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

//nameの情報をデータベースから返す
$name = get_post('name');
//priceの情報をデータベースから返す
$price = get_post('price');
//statusの情報をデータベースから返す
$status = get_post('status');
//stockの情報をデータベースから返す
$stock = get_post('stock');
//imageの情報をデータベースから返す
$image = get_file('image');

//それぞれの情報をregistしたとき
if(regist_item($db, $name, $price, $stock, $status, $image)){
  //メッセージ表示
  set_message('商品を登録しました。');
}else {
  //エラーメッセージ表示
  set_error('商品の登録に失敗しました。');
}


redirect_to(ADMIN_URL);