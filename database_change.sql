-- 14-aug

CREATE TABLE `nainileaf`.`dir_product_wholesale` ( `id` INT UNSIGNED NOT NULL AUTO_INCREMENT , `product_id` INT(11) NOT NULL , `ws_price` FLOAT NULL , `ws_discount` FLOAT NULL , `ws_discount_price` FLOAT NULL , `ws_price_option` TEXT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;


ALTER TABLE `dir_product` ADD `product_sub_category` INT(11) NULL AFTER `product_category`;


ALTER TABLE `dir_product` ADD `is_whole_sale` TINYINT(1) NULL AFTER `price_option`;


ALTER TABLE `dir_product_wholesale`
  DROP `ws_price`,
  DROP `ws_discount`,
  DROP `ws_discount_price`,
  DROP `ws_price_option`; 	

  ALTER TABLE `dir_product_wholesale` ADD `wholesale_price` TEXT NULL AFTER `product_id`;
