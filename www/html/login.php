<?php
//設定ファイルを読み込み
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';

session_start();

//セッション変数からログイン済みか確認
if(is_logined() === true){
  //login.phpにリダイレクト
  redirect_to(HOME_URL);
}

//外部ファイル(login_view.php)がすでに読み込まれているか、チェック（1回目は正常に読み込むが、2回目以降は読み込まない）
include_once VIEW_PATH . 'login_view.php';