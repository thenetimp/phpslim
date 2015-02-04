
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- users
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `email_address` VARCHAR(255) NOT NULL,
    `real_email_address` VARCHAR(255) NOT NULL,
    `password_hash` VARCHAR(255) NOT NULL,
    `first_name` VARCHAR(255) NOT NULL,
    `last_name` VARCHAR(255) NOT NULL,
    `alias` VARCHAR(255) NOT NULL,
    `terms_agree` TINYINT(1) NOT NULL,
    `newsletter_subscribe` TINYINT(1) NOT NULL,
    `failed_login_attempts` INTEGER DEFAULT 0 NOT NULL,
    `last_login_attempt` DATETIME,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `idx_email_address` (`email_address`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- user_groups
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user_groups`;

CREATE TABLE `user_groups`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- user_groups_user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user_groups_user`;

CREATE TABLE `user_groups_user`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `user_id` INTEGER NOT NULL,
    `user_group_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `idx_user_group_user` (`user_id`, `user_group_id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
