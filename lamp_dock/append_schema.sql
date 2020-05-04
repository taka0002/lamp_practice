/*購入履歴画面*/
create TABLE history (
    history_id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    created datetime NOT NULL,
    primary key(history_id)
);

/*購入明細画面*/
create TABLE details (
    details_id INT(11) NOT NULL AUTO_INCREMENT,
    item_id INT(11) NOT NULL,
    history_id INT(11) NOT NULL,
    price INT(11) NOT NULL,
    amount INT(11) NOT NULL,
    created datetime NOT NULL,
    primary key(details_id)
);