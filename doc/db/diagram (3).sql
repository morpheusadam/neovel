CREATE TABLE `users` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255),
  `email` varchar(255) UNIQUE,
  `email_verified_at` timestamp,
  `password` varchar(255),
  `is_active` varchar(255),
  `remember_token` varchar(255),
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) PRIMARY KEY,
  `token` varchar(255),
  `created_at` timestamp
);

CREATE TABLE `sessions` (
  `id` varchar(255) PRIMARY KEY,
  `user_id` int,
  `ip_address` varchar(45),
  `user_agent` text,
  `payload` longtext,
  `last_activity` int
);

CREATE TABLE `roles` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `role_name` varchar(60) UNIQUE,
  `description` varchar(255),
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `permissions` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `permission_name` varchar(60) UNIQUE,
  `description` varchar(255),
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `user_roles` (
  `user_id` int,
  `role_id` int,
  PRIMARY KEY (`user_id`, `role_id`)
);

CREATE TABLE `role_permissions` (
  `role_id` int,
  `permission_id` int,
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`role_id`, `permission_id`)
);

CREATE TABLE `user_meta` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `user_id` int,
  `meta_key` varchar(255),
  `meta_value` text,
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `categories` (
  `id` int PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary key of the categories table',
  `name` varchar(100) UNIQUE COMMENT 'Name of the category, must be unique',
  `description` text COMMENT 'Description of the category',
  `parent_id` int COMMENT 'Parent category ID, references categories.id',
  `slug` varchar(255) UNIQUE COMMENT 'URL-friendly version of the category name, must be unique',
  `image_id` int COMMENT 'Foreign key referencing media table',
  `is_visible` boolean DEFAULT true COMMENT 'Visibility of the category',
  `order_column` int DEFAULT 0 COMMENT 'Order of the category for display purposes',
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `tags` (
  `id` int PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary key of the tags table',
  `name` varchar(50) UNIQUE COMMENT 'Name of the tag, must be unique and up to 50 characters',
  `slug` varchar(255) UNIQUE COMMENT 'URL-friendly version of the tag name, must be unique and up to 255 characters',
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `posts` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `title` varchar(255),
  `slug` varchar(255) UNIQUE COMMENT 'URL-friendly version of the post title, must be unique',
  `content` text COMMENT 'Content of the post',
  `user_id` int COMMENT 'Foreign key referencing users table',
  `category_id` int COMMENT 'Foreign key referencing categories table',
  `is_published` boolean DEFAULT false COMMENT 'Publication status of the post',
  `published_at` timestamp COMMENT 'Publication date of the post',
  `image_id` int COMMENT 'Foreign key referencing media table',
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `comments` (
  `id` int PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary key of the comments table',
  `post_id` int COMMENT 'Foreign key referencing posts table',
  `user_id` int COMMENT 'Foreign key referencing users table',
  `content` text COMMENT 'Content of the comment',
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `post_tags` (
  `post_id` int COMMENT 'Foreign key referencing posts table',
  `tag_id` int COMMENT 'Foreign key referencing tags table',
  `created_at` timestamp,
  `updated_at` timestamp,
  PRIMARY KEY (`post_id`, `tag_id`)
);

CREATE TABLE `post_meta` (
  `id` int PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary key of the post_meta table',
  `post_id` int COMMENT 'Foreign key referencing posts table',
  `meta_key` varchar(50) COMMENT 'Key for the meta information, up to 50 characters',
  `meta_value` text COMMENT 'Value for the meta information, can be null',
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `pages` (
  `id` int PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary key of the pages table',
  `user_id` int COMMENT 'Foreign key referencing users table',
  `title` varchar(255) COMMENT 'Title of the page, up to 255 characters',
  `content` text COMMENT 'Content of the page',
  `slug` varchar(255) UNIQUE COMMENT 'URL-friendly version of the page title, must be unique and up to 255 characters',
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `cache` (
  `key` varchar(255) PRIMARY KEY,
  `value` mediumtext,
  `expiration` int
);

CREATE TABLE `cache_locks` (
  `key` varchar(255) PRIMARY KEY,
  `owner` varchar(255),
  `expiration` int
);

CREATE TABLE `jobs` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `queue` varchar(255),
  `payload` longtext,
  `attempts` tinyint,
  `reserved_at` int,
  `available_at` int,
  `created_at` int
);

CREATE TABLE `job_batches` (
  `id` varchar(255) PRIMARY KEY,
  `name` varchar(255),
  `total_jobs` int,
  `pending_jobs` int,
  `failed_jobs` int,
  `failed_job_ids` longtext,
  `options` mediumtext,
  `cancelled_at` int,
  `created_at` int,
  `finished_at` int
);

CREATE TABLE `failed_jobs` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `uuid` varchar(255) UNIQUE,
  `connection` text,
  `queue` text,
  `payload` longtext,
  `exception` longtext,
  `failed_at` timestamp DEFAULT (CURRENT_TIMESTAMP)
);

CREATE TABLE `filament_exceptions_table` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `type` varchar(255),
  `code` varchar(255),
  `message` longtext,
  `file` varchar(255),
  `line` int,
  `trace` text,
  `method` varchar(255),
  `path` varchar(255),
  `query` text,
  `body` text,
  `cookies` text,
  `headers` text,
  `ip` varchar(255),
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `breezy_sessions` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `authenticatable_type` varchar(255),
  `authenticatable_id` int,
  `panel_id` varchar(255),
  `guard` varchar(255),
  `ip_address` varchar(45),
  `user_agent` text,
  `expires_at` timestamp,
  `two_factor_secret` text,
  `two_factor_recovery_codes` text,
  `two_factor_confirmed_at` timestamp,
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `activity_log` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `log_name` varchar(255),
  `description` text,
  `subject_type` varchar(255),
  `subject_id` bigint,
  `causer_type` varchar(255),
  `causer_id` bigint,
  `properties` json,
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `media` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `disk` varchar(255) DEFAULT 'public',
  `directory` varchar(255) DEFAULT 'media',
  `visibility` varchar(255) DEFAULT 'public',
  `name` varchar(255),
  `path` varchar(255),
  `width` int,
  `height` int,
  `size` int,
  `type` varchar(255) DEFAULT 'image',
  `ext` varchar(255),
  `alt` varchar(255),
  `title` varchar(255),
  `description` text,
  `caption` text,
  `exif` text,
  `curations` longtext,
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `queue_monitors` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `job_id` varchar(255),
  `name` varchar(255),
  `queue` varchar(255),
  `started_at` timestamp,
  `finished_at` timestamp,
  `failed` boolean DEFAULT false,
  `attempt` int DEFAULT 0,
  `progress` int,
  `exception_message` text,
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `notifications` (
  `id` uuid PRIMARY KEY,
  `type` varchar(255),
  `notifiable_type` varchar(255),
  `notifiable_id` bigint,
  `data` json,
  `read_at` timestamp,
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE INDEX `roles_index_0` ON `roles` (`role_name`);

CREATE INDEX `permissions_index_1` ON `permissions` (`permission_name`);

CREATE UNIQUE INDEX `user_meta_index_2` ON `user_meta` (`user_id`, `meta_key`);

CREATE INDEX `user_meta_index_3` ON `user_meta` (`meta_key`);

CREATE INDEX `jobs_index_4` ON `jobs` (`queue`);

CREATE INDEX `activity_log_index_5` ON `activity_log` (`log_name`);

CREATE INDEX `activity_log_index_6` ON `activity_log` (`subject_type`, `subject_id`);

CREATE INDEX `activity_log_index_7` ON `activity_log` (`causer_type`, `causer_id`);

CREATE INDEX `queue_monitors_index_8` ON `queue_monitors` (`job_id`);

CREATE INDEX `queue_monitors_index_9` ON `queue_monitors` (`started_at`);

CREATE INDEX `queue_monitors_index_10` ON `queue_monitors` (`failed`);

CREATE INDEX `notifications_index_11` ON `notifications` (`notifiable_type`, `notifiable_id`);

ALTER TABLE `sessions` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `user_roles` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `user_roles` ADD FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

ALTER TABLE `role_permissions` ADD FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

ALTER TABLE `role_permissions` ADD FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`);

ALTER TABLE `user_meta` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `categories` ADD FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`);

ALTER TABLE `categories` ADD FOREIGN KEY (`image_id`) REFERENCES `media` (`id`);

ALTER TABLE `posts` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `posts` ADD FOREIGN KEY (`image_id`) REFERENCES `media` (`id`);

ALTER TABLE `comments` ADD FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);

ALTER TABLE `comments` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `post_tags` ADD FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);

ALTER TABLE `post_tags` ADD FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`);

ALTER TABLE `post_meta` ADD FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);

ALTER TABLE `pages` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
