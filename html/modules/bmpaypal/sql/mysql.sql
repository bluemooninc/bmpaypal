##
## orderId = YYMMDDHHMMSS-UID
## status = 0: Un paid 1: Paid
##
CREATE TABLE {prefix}_{dirname}_payment (
  `id` int(8) unsigned NOT NULL auto_increment,
  `uid` int(8) unsigned NOT NULL,
  `order_id` varchar(27) NOT NULL,
  `amount` decimal(9,2),
  `currency` varchar(8) NOT NULL,
  `paypal_id` varchar(32) NOT NULL,
  `state` varchar(32) NOT NULL,
  `payer_id` varchar(16),
  `utime` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY uid (`uid`)
) ENGINE = MYISAM ;
