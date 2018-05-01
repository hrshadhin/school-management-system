CREATE TABLE `ClassOffDay` (
   `id` int(10) UNSIGNED NOT NULL,
   `offDate` date NOT NULL,
   `description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
   `status` smallint(6) NOT NULL DEFAULT '1',
   `created_at` timestamp NULL DEFAULT NULL,
   `updated_at` timestamp NULL DEFAULT NULL
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
 ALTER TABLE `ClassOffDay` ADD PRIMARY KEY (`id`);
 ALTER TABLE `ClassOffDay` MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
 ALTER TABLE `ClassOffDay` ADD `oType` ENUM('E','O','CP') NOT NULL DEFAULT 'O' AFTER `offDate`;