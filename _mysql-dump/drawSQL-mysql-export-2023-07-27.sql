CREATE TABLE `users`(
    `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `screenName` VARCHAR(255) NOT NULL,
    `firstName` VARCHAR(255) NOT NULL,
    `lastName` VARCHAR(255) NOT NULL,
    `gender` BIGINT NOT NULL,
    `birthday` DATE NULL,
    `dateCreated` DATETIME NOT NULL,
    `dateDeleted` DATETIME NULL,
    `picture` VARCHAR(255) NULL,
    `publicMessage` TEXT NOT NULL
);
CREATE TABLE `groupMembers`(
    `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `usergroup` BIGINT NOT NULL,
    `user` BIGINT NOT NULL
);
CREATE TABLE `genders`(
    `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL
);
CREATE TABLE `publicPosts`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user` BIGINT NOT NULL,
    `text` TEXT NOT NULL,
    `datePosted` TIMESTAMP NOT NULL
);
CREATE TABLE `privateMessages`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `sender` BIGINT NOT NULL,
    `receiver` BIGINT NOT NULL,
    `message` TEXT NOT NULL,
    `timestamp` TIMESTAMP NOT NULL
);
CREATE TABLE `groupMessages`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `sender` BIGINT NOT NULL,
    `text` TEXT NOT NULL,
    `timestamp` TIMESTAMP NOT NULL
);
CREATE TABLE `groupChats`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `usergroup` BIGINT NOT NULL,
    `message` BIGINT NOT NULL
);
CREATE TABLE `userGroups`(
    `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL
);
CREATE TABLE `meetUps`(
    `id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `date` DATETIME NOT NULL,
    `usergroup` BIGINT NOT NULL,
    `restaurant` VARCHAR(255) NULL,
    `note` TEXT NULL
);
CREATE TABLE `groupInvites`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `usergroup` BIGINT NOT NULL,
    `invitee` BIGINT NOT NULL,
    `sender` BIGINT NOT NULL,
    `timestamp` TIMESTAMP NOT NULL
);
ALTER TABLE
    `groupMembers` ADD CONSTRAINT `groupmembers_user_foreign` FOREIGN KEY(`user`) REFERENCES `users`(`id`);
ALTER TABLE
    `publicPosts` ADD CONSTRAINT `publicposts_user_foreign` FOREIGN KEY(`user`) REFERENCES `users`(`id`);
ALTER TABLE
    `groupChats` ADD CONSTRAINT `groupchats_message_foreign` FOREIGN KEY(`message`) REFERENCES `groupMessages`(`id`);
ALTER TABLE
    `privateMessages` ADD CONSTRAINT `privatemessages_sender_foreign` FOREIGN KEY(`sender`) REFERENCES `users`(`id`);
ALTER TABLE
    `users` ADD CONSTRAINT `users_gender_foreign` FOREIGN KEY(`gender`) REFERENCES `genders`(`id`);
ALTER TABLE
    `groupInvites` ADD CONSTRAINT `groupinvites_sender_foreign` FOREIGN KEY(`sender`) REFERENCES `users`(`id`);
ALTER TABLE
    `privateMessages` ADD CONSTRAINT `privatemessages_receiver_foreign` FOREIGN KEY(`receiver`) REFERENCES `users`(`id`);
ALTER TABLE
    `groupMessages` ADD CONSTRAINT `groupmessages_sender_foreign` FOREIGN KEY(`sender`) REFERENCES `users`(`id`);
ALTER TABLE
    `groupChats` ADD CONSTRAINT `groupchats_usergroup_foreign` FOREIGN KEY(`usergroup`) REFERENCES `userGroups`(`id`);
ALTER TABLE
    `groupInvites` ADD CONSTRAINT `groupinvites_invitee_foreign` FOREIGN KEY(`invitee`) REFERENCES `users`(`id`);
ALTER TABLE
    `groupInvites` ADD CONSTRAINT `groupinvites_usergroup_foreign` FOREIGN KEY(`usergroup`) REFERENCES `userGroups`(`id`);
ALTER TABLE
    `meetUps` ADD CONSTRAINT `meetups_usergroup_foreign` FOREIGN KEY(`usergroup`) REFERENCES `userGroups`(`id`);
ALTER TABLE
    `groupMembers` ADD CONSTRAINT `groupmembers_usergroup_foreign` FOREIGN KEY(`usergroup`) REFERENCES `userGroups`(`id`);