CREATE TABLE IF NOT EXISTS qb_price_trace (
	id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(id),
	meta_key varchar(1023),
	meta_value text
) ENGINE=MyISAM DEFAULT CHARSET=utf8
				