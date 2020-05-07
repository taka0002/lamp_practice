<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  
  <title>商品一覧</title>
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'index.css'); ?>">
</head>
<body>
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  <a href="history.php">購入履歴はこちらから</a>

  <div class="container">
    <h1>商品一覧</h1>
    <?php include VIEW_PATH . 'templates/messages.php'; ?>

    <div class="card-deck">
      <div class="row">
        <?php foreach($disp_data as $item){ ?>
          <div class="col-6 item">
            <div class="card h-100 text-center">
              <div class="card-header">
                <?php print h($item['name']); ?>
              </div>
              <figure class="card-body">
                <img class="card-img" src="<?php print(IMAGE_PATH . $item['image']); ?>">
                <figcaption>
                  <?php print(number_format($item['price'])); ?>円
                  <?php if($item['stock'] > 0){ ?>
                    <form action="index_add_cart.php" method="post">
                      <input type="submit" value="カートに追加" class="btn btn-primary btn-block">
                      <input type="hidden" name="item_id" value="<?php print($item['item_id']); ?>">
                      <input type="hidden" name="csrf_token" value="<?php print $token; ?>">
                    </form>
                  <?php } else { ?>
                    <p class="text-danger">現在売り切れです。</p>
                  <?php } ?>
                </figcaption>
              </figure>
            </div>
          </div>
        <?php } ?>
      </div>
      <div class="pagi_nation">
        <form method="get" action="index.php">
          <p>
            <?php print $items_num. '件中'.$page_ini. "-" .$page_fin. "件目の商品"; ?>
          </p>
          <p>
          <?php
            // リンクをつけるかの判定
            if($now > 1){ 
                print '<a href=\'index.php?page_id='.($now - 1).'\')>前へ</a>'. '　';
            } else {
                print '前へ'. '　';
            }
            
            for($i = 1; $i <= $max_page; $i++){
              if ($i == $now) {
                  print '<a class="current_page" href=\'index.php?page_id='.$now.'\')>'. $now. '</a>'. '　';
              } else {
                  print '<a href=\'index.php?page_id='.$i. '\')>'. $i. '</a>'. '　';
              }
            }
            // リンクをつけるかの判定
            if($now < $max_page){ 
                print '<a href=\'index.php?page_id='.($now + 1).'\')>次へ</a>'. '　';
            } else {
                print '次へ';
            }
          ?>
          </p>
        </form>
      </div>
    </div>
  </div>
  
</body>
</html>