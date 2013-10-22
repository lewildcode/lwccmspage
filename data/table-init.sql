CREATE TABLE `cms_page` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lft` int(11) unsigned NOT NULL,
  `rgt` int(11) unsigned NOT NULL,
  `isVisible` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `visibilityStart` datetime DEFAULT NULL,
  `visibilityEnd` datetime DEFAULT NULL,
  `layout` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `identifier` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
  `subtitle` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `summary` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `metaHeadScript` text COLLATE utf8_unicode_ci,
  `metaHeadLink` text COLLATE utf8_unicode_ci,
  `metaInlineScript` text COLLATE utf8_unicode_ci,
  `changefreq` enum('always','hourly','daily','weekly','monthly','yearly','never') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'monthly',
  `priority` decimal(1,1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `identifier` (`identifier`),
  KEY `lft` (`lft`),
  KEY `rgt` (`rgt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `cms_row` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(11) unsigned NOT NULL,
  `position` smallint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  CONSTRAINT `cms_row_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `cms_page` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;