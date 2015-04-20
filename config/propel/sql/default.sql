
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
    `emailAddress` VARCHAR(255) NOT NULL,
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
    UNIQUE INDEX `idx_email_address` (`emailAddress`)
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
    `userId` INTEGER NOT NULL,
    `userGroupId` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `idx_user_group_user` (`userId`, `userGroupId`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- clients
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `clients`;

CREATE TABLE `clients`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- states
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `states`;

CREATE TABLE `states`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `abbrv` VARCHAR(255) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- client_states
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `client_states`;

CREATE TABLE `client_states`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `clientId` INTEGER NOT NULL,
    `stateId` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `idx_client_states` (`clientId`, `stateId`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- lead_types
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `lead_types`;

CREATE TABLE `lead_types`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `typeName` VARCHAR(255) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- leads
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `leads`;

CREATE TABLE `leads`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `hash` VARCHAR(255) NOT NULL,
    `leadTypeId` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- lead_attributes
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `lead_attributes`;

CREATE TABLE `lead_attributes`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `attribName` VARCHAR(255) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `idx_lead_attrib_name` (`attribName`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- lead_type_lead_attributes
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `lead_type_lead_attributes`;

CREATE TABLE `lead_type_lead_attributes`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `leadTypeId` INTEGER NOT NULL,
    `leadAttributeId` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `idx_lead_attrib_name` (`leadTypeId`, `leadAttributeId`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- lead_attribute_values
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `lead_attribute_values`;

CREATE TABLE `lead_attribute_values`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `leadId` INTEGER NOT NULL,
    `leadAttributeId` INTEGER NOT NULL,
    `attribValue` VARCHAR(255) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `idx_lead_lead_attribute_value` (`leadId`, `leadAttributeId`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
