<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>カート</title>
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'history.css'); ?>">
</head>
<body>
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  <h1>購入履歴</h1>
  <div class="container">

    <?php include VIEW_PATH . 'templates/messages.php'; ?>

    <?php if(count($history) > 0) { ?>
    <table class="table table-bordered">
      <thead class="thead-light">
        <tr>
          <th>注文番号</th>
          <th>購入日時</th>
          <th>該当の注文の合計金額</th>
          <th>購入明細</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($history as $value){ ?>
          <form method="post" action="details.php">
            <tr>
              <td><?php print($value['history_id']); ?></td>
              <td><?php print($value['created']); ?></td>
              <td><?php print($value['total_price']); ?></td>
              <td><input class="btn btn-block btn-primary" type="submit" value="購入明細表示"></td>
            </tr>
            <input type="hidden" name="history_id" value="<?php print($value['history_id']); ?>">
            <input type="hidden" name="created" value="<?php print($value['created']); ?>">
            <input type="hidden" name="total_price" value="<?php print($value['total_price']); ?>">
          </form>
        <?php } ?>
      </tbody>
    </table>
    <?php } else { ?>
      <p>購入履歴はありません。</p>
    <?php } ?> 
  </div>
</body>
</html>