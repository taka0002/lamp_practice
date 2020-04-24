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

//postで受け取ったnameを定義
$name = get_post('name');
//postで受け取ったpriceを定義
$price = get_post('price');
//postで受け取ったstatusを定義
$status = get_post('status');
//postで受け取ったstockを定義
$stock = get_post('stock');
//postで受け取ったimageを定義
$image = get_file('image');

//regist_item_transaction関数により、itemsテーブルに商品が登録されて、画像が保存されたとき
if(regist_item($db, $name, $price, $stock, $status, $image)){
  //メッセージ表示
  set_message('商品を登録しました。');
}else {
  //エラーメッセージ表示
  set_error('商品の登録に失敗しました。');
}

//管理画面にリダイレクト
redirect_to(ADMIN_URL);