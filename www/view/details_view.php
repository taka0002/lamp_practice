<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>カート</title>
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'details.css'); ?>">
</head>
<body>
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  <h1>購入明細</h1>
  <div class="container">

    <?php include VIEW_PATH . 'templates/messages.php'; ?>
    <ul>
          <li>注文番号：<span><?php print($history_id); ?></span></th>
          <li>購入日時：<span><?php print($created); ?></span></th>
          <li>合計金額：<span><?php print($total_price); ?></span></th>
    </ul>
    <table class="table table-bordered">
      <thead class="thead-light">
        <tr>
          <th>商品名</th>
          <th>購入時の商品価格</th>
          <th>購入数</th>
          <th>小計</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($details as $value){ ?>
            <tr>
              <td><?php print($value['name']); ?></td>
              <td><?php print($value['price']); ?></td>
              <td><?php print($value['amount']); ?></td>
              <td><?php print($value['price'] * $value['amount']); ?></td>
            </tr>
        <?php } ?>
      </tbody>
    </table>
    <a href="history.php">購入履歴画面に戻る</a>
  </div>
</body>
</html>