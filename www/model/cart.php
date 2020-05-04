<?php 
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

//get_user_carts関数の定義
function get_user_carts($db, $user_id){
  $sql = "
    SELECT
      items.item_id,
      items.name,
      items.price,
      items.stock,
      items.status,
      items.image,
      carts.cart_id,
      carts.user_id,
      carts.amount
    FROM
      carts
    JOIN
      items
    ON
      carts.item_id = items.item_id
    WHERE
      carts.user_id = {$user_id}
  ";
  return fetch_all_query($db, $sql);
}

//get_user_cart関数の定義
function get_user_cart($db, $user_id, $item_id){
  $sql = "
    SELECT
      items.item_id,
      items.name,
      items.price,
      items.stock,
      items.status,
      items.image,
      carts.cart_id,
      carts.user_id,
      carts.amount
    FROM
      carts
    JOIN
      items
    ON
      carts.item_id = items.item_id
    WHERE
      carts.user_id = {$user_id}
    AND
      items.item_id = {$item_id}
  ";

  return fetch_query($db, $sql);

}

//add_cart関数の定義
function add_cart($db, $user_id, $item_id) {
  $cart = get_user_cart($db, $user_id, $item_id);
  if($cart === false){
    return insert_cart($db, $user_id, $item_id);
  }
  return update_cart_amount($db, $cart['cart_id'], $cart['amount'] + 1);
}

function insert_cart($db, $user_id, $item_id, $amount = 1){
  $sql = "
    INSERT INTO
      carts(
        item_id,
        user_id,
        amount
      )
    VALUES(?, ?, ?)
  ";

  return execute_query($db, $sql, array($item_id, $user_id, $amount));
}

//update_cart_amount関数の定義
function update_cart_amount($db, $cart_id, $amount){

    $sql = "
    UPDATE
      carts
    SET
      amount = ?
    WHERE
      cart_id = ?
    LIMIT 1
  ";
  
  return execute_query($db, $sql, array($amount, $cart_id));

}

//delete_cart関数の定義
function delete_cart($db, $cart_id){
  $sql = "
    DELETE FROM
      carts
    WHERE
      cart_id = ?
    LIMIT 1
  ";

  return execute_query($db, $sql, array($cart_id));
}

//purchase_carts関数の定義
function purchase_carts($db, $carts){
  if(validate_cart_purchase($carts) === false){
    return false;
  }
  foreach($carts as $cart){
    if(update_item_stock(
        $db, 
        $cart['item_id'], 
        $cart['stock'] - $cart['amount']
      ) === false){
      set_error($cart['name'] . 'の購入に失敗しました。');
    }
  }
  insert_history($db, $carts[0]['user_id']);
  $history_id = $db->lastInsertId();
  foreach($carts as $cart) {
    insert_details($db, $cart['item_id'], $history_id, $cart['price'], $cart['amount']);
  }
  delete_user_carts($db, $carts[0]['user_id']);
}

//delete_user_carts関数の定義
function delete_user_carts($db, $user_id){
  $sql = "
    DELETE FROM
      carts
    WHERE
      user_id = ?
  ";

  execute_query($db, $sql, array($user_id));
}

//sum_carts関数の定義
function sum_carts($carts){
  $total_price = 0;
  foreach($carts as $cart){
    $total_price += $cart['price'] * $cart['amount'];
  }
  return $total_price;
}

//sum_carts関数の定義
function validate_cart_purchase($carts){
  if(count($carts) === 0){
    set_error('カートに商品が入っていません。');
    return false;
  }
  foreach($carts as $cart){
    if(is_open($cart) === false){
      set_error($cart['name'] . 'は現在購入できません。');
    }
    if($cart['stock'] - $cart['amount'] < 0){
      set_error($cart['name'] . 'は在庫が足りません。購入可能数:' . $cart['stock']);
    }
  }
  if(has_error() === true){
    return false;
  }
  return true;
}

//insert_history関数の定義(購入履歴)
function insert_history($db, $user_id) {
  $sql = "
    INSERT INTO
      history(
        user_id
      )
    VALUES(?)
  ";

  return execute_query($db, $sql, array($user_id));
}

//insert_details関数の定義(購入明細)
function insert_details($db, $item_id, $history_id, $price, $amount) {
  $sql = "
    INSERT INTO
      details(
        item_id,
        history_id,
        price,
        amount
      )
    VALUES(?, ?, ?, ?)
  ";

return execute_query($db, $sql, array($item_id, $history_id, $price, $amount));
}

//get_history関数の定義
function get_history($db, $user_id = 4) {
  if($user_id !== 4){
    $where = " WHERE history.user_id = {$user_id}";
  } else {
    $where = "";
  }
  $sql = "
  SELECT
    history.history_id,
    history.created,
    SUM(details.price * details.amount) as total_price
  FROM
    history
  JOIN
    details
  ON
    history.history_id = details.history_id
  {$where}
  GROUP BY
    history_id
  ORDER BY
    created DESC";

  return fetch_all_query($db, $sql);
}

//get_details関数の定義
function get_details($db, $history_id) {
  $sql = "
  SELECT
    details.price,
    details.amount,
    items.name
  FROM
    details
  JOIN
    items
  ON
    details.item_id = items.item_id
  WHERE
    details.history_id = {$history_id}";
    
  return fetch_all_query($db, $sql);
}