<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Name:  Install Model
 *
 * Version: 0.0.1
 *
 * Author:  Chris Baines
 * 		    chris@doveforums.com
 *
 * Location: http://github.com/chrisbaines/DoveForums
 *
 * Description:  Installation model for Dove Forums.
 *
 * Requirements: PHP5 or above
 *
 */

class Install_M extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function create_database($database_name)
    {

        $this->load->database();
        $this->load->dbforge();

        if ($this->dbforge->create_database($database_name))
        {
            $find    = "'database' =>";
            $replace = "\t" . "'database' => '" . $database_name . "'," . "\n";

            if ($this->edit_database_config($find, $replace) === true)
            {
                return TRUE;
            }
        }

        return FALSE;
    }

    public function create_tables()
    {

        $this->load->database();
        $this->load->dbforge();

        // Create sessions table.
        $sql = "
			CREATE TABLE IF NOT EXISTS `ci_sessions` (
			  `id` varchar(40) NOT NULL,
			  `ip_address` varchar(45) NOT NULL,
			  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
			  `data` blob NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		";

        if(!$this->db->query($sql))
        {
            return FALSE;
        }

        // Create categories table.
        $sql = "
            CREATE TABLE `categories` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key used to identify the category. It has no other meaning. ',
              `name` varchar(200) DEFAULT 'New Category' COMMENT 'The category name.',
              `slug` varchar(200) DEFAULT '' COMMENT 'The category slug.',
              `discussion_count` int(10) DEFAULT '0' COMMENT 'The number of discussions in this category.',
              `comment_count` int(10) DEFAULT '0' COMMENT 'The number of comments in this category.',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
        ";

        if(!$this->db->query($sql))
        {
            return FALSE;
        }

        // Create comments table.
        $sql = "
            CREATE TABLE `comments` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key used to identify the comment. It has no other meaning.',
              `discussion_id` int(10) DEFAULT '0' COMMENT 'The ID of the parent discussion for this comment.',
              `poster` varchar(200) DEFAULT '' COMMENT 'The username of the user who created the comment.',
              `poster_id` int(10) DEFAULT '1' COMMENT 'The ID of the user who created the comment.',
              `poster_ip` varchar(39) DEFAULT NULL COMMENT 'The IP address of the user who created the comment.',
              `poster_email` varchar(80) DEFAULT NULL COMMENT 'If a guest created the comment, their email address. If a logged in user created it, then NULL.',
              `message` mediumtext COMMENT 'The contents of the comment.',
              `hide_smilies` tinyint(1) DEFAULT '0' COMMENT 'Shoult smilies be hidden in this post?',
              `posted` int(10) DEFAULT '0' COMMENT 'A Unix timestamp representing the time the comment was created.',
              `edited` int(10) DEFAULT NULL COMMENT 'A Unix timestamp representing the time the comment was edited.',
              `edited_by` varchar(200) DEFAULT NULL COMMENT 'The Username of the user who last edited the post, NULL if it hasn`t been edited.',
              `deleted` int(10) DEFAULT '0' COMMENT 'Has the comment been deleted?',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
        ";

        if(!$this->db->query($sql))
        {
            return FALSE;
        }

        // Create discussions table.
        $sql = "
            CREATE TABLE `discussions` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key used to identify the discussion. It has no other meaning.',
              `category_id` int(10) DEFAULT '0' COMMENT 'The ID of the parent category this discussion belongs to.',
              `poster` varchar(200) DEFAULT '' COMMENT 'The Username of the user who created the discussion.',
              `posted` int(10) DEFAULT '0' COMMENT 'A Unix timestamp representing the time the discussion was created.',
              `subject` varchar(200) DEFAULT '' COMMENT 'The subject of the discussion.',
              `first_comment_id` int(11) DEFAULT '0' COMMENT 'The ID of the first comment in this discussion.',
              `last_comment` int(11) DEFAULT '0' COMMENT 'A Unix timestamp of the time the last comment was made to the discussion.',
              `last_comment_id` int(11) DEFAULT '0' COMMENT 'The ID of the last comment in the discussion.',
              `last_poster` varchar(200) DEFAULT NULL COMMENT 'The Username of the user who posted the last comment.',
              `last_poster_id` int(10) DEFAULT NULL COMMENT 'The ID or the user who created the last post.',
              `views` mediumint(8) DEFAULT '0' COMMENT 'The number of times the discussion has been viewed.',
              `replies` mediumint(8) DEFAULT '0' COMMENT 'The number of coments to the discussion.',
              `closed` tinyint(1) DEFAULT '0' COMMENT 'Is the discussion closed?',
              `sticky` tinyint(1) DEFAULT '0' COMMENT 'Is the discussion as sticky?',
              `moved_to` int(10) DEFAULT NULL COMMENT 'If the discussion has been moved, the ID of the new discussion (This one now acts as a redirect).',
              `deleted` int(10) DEFAULT '0' COMMENT 'Has the discussion been deleted?',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
        ";

        if(!$this->db->query($sql))
        {
            return FALSE;
        }

        // Create groups table.
        $sql = "
            CREATE TABLE IF NOT EXISTS `groups` (
              `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
              `name` varchar(20) NOT NULL,
              `description` varchar(100) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ";

        if(!$this->db->query($sql))
        {
            return FALSE;
        }

        // Create logging attempts table.
        $sql = "
            CREATE TABLE IF NOT EXISTS `login_attempts` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `ip_address` varchar(15) NOT NULL,
              `login` varchar(100) NOT NULL,
              `time` int(11) unsigned DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ";

        if(!$this->db->query($sql))
        {
            return FALSE;
        }

        // Create users table.
        $sql = "
            CREATE TABLE IF NOT EXISTS `users` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `ip_address` varchar(15) NOT NULL,
              `username` varchar(100) NOT NULL,
              `password` varchar(255) NOT NULL,
              `salt` varchar(255) DEFAULT NULL,
              `email` varchar(100) NOT NULL,
              `activation_code` varchar(40) DEFAULT NULL,
              `forgotten_password_code` varchar(40) DEFAULT NULL,
              `forgotten_password_time` int(11) unsigned DEFAULT NULL,
              `remember_code` varchar(40) DEFAULT NULL,
              `created_on` int(11) unsigned NOT NULL,
              `last_login` int(11) unsigned DEFAULT NULL,
              `active` tinyint(1) unsigned DEFAULT NULL,
              `first_name` varchar(50) DEFAULT NULL,
              `last_name` varchar(50) DEFAULT NULL,
              `company` varchar(100) DEFAULT NULL,
              `phone` varchar(20) DEFAULT NULL,
              `visit_count` int(11) DEFAULT '0',
              `comments` int(11) DEFAULT NULL,
              `discussions` int(11) DEFAULT NULL,
              `language` varchar(255) DEFAULT 'english',
              `reported` int(11) NOT NULL DEFAULT '0',
              `report_reason` varchar(255) NOT NULL,
              `report_date` datetime NOT NULL,
              `report_user_id` int(11) NOT NULL,
              `points` int(11) DEFAULT 0,
              `last_activity` int(10) DEFAULT NULL,
              `notify_of_replies` int(10) DEFAULT '0',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
        ";

        if(!$this->db->query($sql))
        {
            return FALSE;
        }

        // Create users groups table.
        $sql = "
            CREATE TABLE IF NOT EXISTS `users_groups` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `user_id` int(11) unsigned NOT NULL,
              `group_id` mediumint(8) unsigned NOT NULL,
              PRIMARY KEY (`id`),
              UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
              KEY `fk_users_groups_users1_idx` (`user_id`),
              KEY `fk_users_groups_groups1_idx` (`group_id`),
              CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
              CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ";

        if(!$this->db->query($sql))
        {
            return FALSE;
        }

        // Create settings table.
        $sql = "
            CREATE TABLE `settings` (
              `option_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `option_name` varchar(64) NOT NULL DEFAULT '',
              `option_value` mediumtext NOT NULL,
              `option_group` varchar(55) NOT NULL DEFAULT 'site',
              `auto_load` enum('no','yes') NOT NULL DEFAULT 'yes',
              PRIMARY KEY (`option_id`,`option_name`),
              KEY `option_name` (`option_name`),
              KEY `auto_load` (`auto_load`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;
        ";

        if(!$this->db->query($sql))
        {
            return FALSE;
        }

        // Create language_packs table.
        $sql = "
            CREATE TABLE `language_packs` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `language` varchar(255) DEFAULT NULL,
              `code` varchar(255) DEFAULT NULL,
              `icon` varchar(100) DEFAULT NULL,
              `deletable` int(11) DEFAULT '1',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ";

        if(!$this->db->query($sql))
        {
            return FALSE;
        }

        // Create permissions table.
        $sql = "
            CREATE TABLE `permissions` (
              `permission_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `permission` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
              `key` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
              `category` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
              PRIMARY KEY (`permission_id`),
              UNIQUE KEY `key` (`key`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ";

        if(!$this->db->query($sql))
        {
            return FALSE;
        }

        // Create permission_map table.
        $sql = "
            CREATE TABLE `permission_map` (
              `group_id` int(11) NOT NULL DEFAULT '0',
              `permission_id` int(11) NOT NULL DEFAULT '0'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ";

        if(!$this->db->query($sql))
        {
            return FALSE;
        }

        // Create achievements table.
        $sql = "
            CREATE TABLE IF NOT EXISTS `achievements` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `name` varchar(255) NOT NULL,
              `description` text NOT NULL,
              `points` int(11) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
        ";

        if(!$this->db->query($sql))
        {
            return FALSE;
        }

        // Create achievement_triggers table.
        $sql = "
            CREATE TABLE IF NOT EXISTS `achievement_triggers` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `action` varchar(255) NOT NULL,
              `condition` varchar(255) NOT NULL,
              `achievement_id` int(11) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
        ";

        if(!$this->db->query($sql))
        {
            return FALSE;
        }

        // Create user_achievements table.
        $sql = "
            CREATE TABLE IF NOT EXISTS `user_achievements` (
              `achievement_id` int(11) NOT NULL,
              `user_id` int(11) NOT NULL,
              `date_received` datetime NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ";

        if(!$this->db->query($sql))
        {
            return FALSE;
        }

        // Create the reports table.
        $sql = "
            CREATE TABLE `reports` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key used to identify the report. It has no other meaning.',
              `comment_id` int(10) DEFAULT '0' COMMENT 'The ID of the reported comment.',
              `discussion_id` int(10) DEFAULT '0' COMMENT 'The ID of the discussion in which the reported comment is contained.',
              `reported_by` int(10) DEFAULT '0' COMMENT 'The ID of the user who created the report.',
              `created` int(10) DEFAULT '0' COMMENT 'A Unix timestamp representing the time this report was created.',
              `message` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'The report message entered by the user.',
              `zapped` int(10) DEFAULT NULL COMMENT 'A Unix timestamp representing the time this report was zappes (marked as read).',
              `zapped_by` int(10) DEFAULT NULL COMMENT 'The ID of the user who zapped this report.',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ";

        if(!$this->db->query($sql))
        {
            return FALSE;
        }

        // Create the themes table.
        $sql = "
            CREATE TABLE `themes` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `name` varchar(250) DEFAULT NULL,
              `description` mediumtext,
              `url` varchar(255) DEFAULT NULL,
              `author` varchar(255) DEFAULT NULL,
              `author_url` varchar(255) DEFAULT NULL,
              `thumb` varchar(250) DEFAULT NULL,
              `status` tinyint(1) DEFAULT '0',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ";

        if(!$this->db->query($sql))
        {
            return FALSE;
        }

        // Create the thumbs table.
        $sql = "
            CREATE TABLE IF NOT EXISTS `thumbs` (
              `id` int(10) NOT NULL AUTO_INCREMENT,
              `discussion_id` int(10) NOT NULL DEFAULT '0',
              `comment_id` int(10) NOT NULL DEFAULT '0',
              `recipient_user_id` int(10) NOT NULL DEFAULT '0',
              `recipient_username` varchar(250) DEFAULT NULL,
              `giver_user_id` int(10) NOT NULL DEFAULT '0',
              `giver_username` varchar(250) DEFAULT NULL,
              `given` int(10) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
        ";

        if(!$this->db->query($sql))
        {
            return FALSE;
        }

        // Create unread table.
        $sql = "
            CREATE TABLE `unread` (
              `discussion_id` int(10) DEFAULT NULL,
              `user_id` int(10) DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ";

        if(!$this->db->query($sql))
        {
            return FALSE;
        }

        // Add default themes.
        $sql = "
            INSERT INTO `themes` (`id`, `name`, `description`, `url`, `author`, `author_url`, `thumb`, `status`)
            VALUES
                (1,'default','Default theme.',NULL,'Bootstrap','http://getbootstrap.com','default.png',0),
                (2,'cerulean','A calm blue sky.','https://maxcdn.bootstrapcdn.com/bootswatch/3.3.5/cerulean/bootstrap.min.css','Bootswatch','https://bootswatch.com','cerulean.png',0),
                (3,'cosmo','An ode to Metro.','https://maxcdn.bootstrapcdn.com/bootswatch/3.3.5/cosmo/bootstrap.min.css','Bootswatch','https://bootswatch.com','cosmo.png',0),
                (4,'cyborg','Jet black and electric blue.','https://maxcdn.bootstrapcdn.com/bootswatch/3.3.5/cyborg/bootstrap.min.css','Bootswatch','https://bootswatch.com','cyborg.png',0),
                (5,'darkly','Flatly in night mode.','https://maxcdn.bootstrapcdn.com/bootswatch/3.3.5/darkly/bootstrap.min.css','Bootswatch','https://bootswatch.com','darkly.png',0),
                (6,'flatly','Flat and modern.	','https://maxcdn.bootstrapcdn.com/bootswatch/3.3.5/flatly/bootstrap.min.css','Bootswatch','https://bootswatch.com','flatly.png',0),
                (7,'journal','Crisp like a new sheet of paper.','https://maxcdn.bootstrapcdn.com/bootswatch/3.3.5/journal/bootstrap.min.css','Bootswatch','https://bootswatch.com','journal.png',0),
                (8,'lumen','Light and shadow.	','https://maxcdn.bootstrapcdn.com/bootswatch/3.3.5/lumen/bootstrap.min.css','Bootswatch','https://bootswatch.com','lumen.png',0),
                (9,'paper','Material is the metaphor.','https://maxcdn.bootstrapcdn.com/bootswatch/3.3.5/paper/bootstrap.min.css','Bootswatch','https://bootswatch.com','paper.png',0),
                (10,'readable','Optimized for legibility.','https://maxcdn.bootstrapcdn.com/bootswatch/3.3.5/readable/bootstrap.min.css','Bootswatch','https://bootswatch.com','readable.png',0),
                (11,'sandstone','A touch of warmth.','https://maxcdn.bootstrapcdn.com/bootswatch/3.3.5/sandstone/bootstrap.min.css','Bootswatch','https://bootswatch.com','sandstone.png',0),
                (12,'simplex','Mini and minimalist.','https://maxcdn.bootstrapcdn.com/bootswatch/3.3.5/simplex/bootstrap.min.css','Bootswatch','https://bootswatch.com','simplex.png',0),
                (13,'slate','Shades of gunmetal gray.','https://maxcdn.bootstrapcdn.com/bootswatch/3.3.5/slate/bootstrap.min.css','Bootswatch','https://bootswatch.com','slate.png',0),
                (14,'spacelab','Silvery and sleek.','https://maxcdn.bootstrapcdn.com/bootswatch/3.3.5/spacelab/bootstrap.min.css','Bootswatch','https://bootswatch.com','spacelab.png',0),
                (15,'superhero','The brave and the blue.','https://maxcdn.bootstrapcdn.com/bootswatch/3.3.5/superhero/bootstrap.min.css','Bootswatch','https://bootswatch.com','superhero.png',0),
                (16,'united','Ubunty orange and unique font.','https://maxcdn.bootstrapcdn.com/bootswatch/3.3.5/united/bootstrap.min.css','Bootswatch','https://bootswatch.com','united.png',0),
                (17,'yeti','A friendly foundation.','https://maxcdn.bootstrapcdn.com/bootswatch/3.3.5/yeti/bootstrap.min.css','Bootswatch','https://bootswatch.com','yeti.png',1);
	    ";

        if(!$this->db->query($sql))
        {
            return FALSE;
        }

        // Add default groups.
        $sql = "
            INSERT INTO `groups` (`id`, `name`, `description`)
            VALUES
                (1,'guest','Guest'),
                (2,'admin','Administrator'),
                (3,'members','General User'),
                (4,'moderator','Moderators');
	    ";

        if(!$this->db->query($sql))
        {
            return FALSE;
        }

        // Add default guest user.
        $sql = "
            INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `visit_count`, `comments`, `discussions`, `language`, `reported`, `report_reason`, `report_date`, `report_user_id`, `points`, `last_activity`)
            VALUES
                (1,'::0','Guest','',NULL,'',NULL,NULL,NULL,NULL,1433427728,NULL,0,'Guest','User',NULL,NULL,1,NULL,NULL,'english',0,'','0000-00-00 00:00:00',0, 0, NULL);
	    ";

        if(!$this->db->query($sql))
        {
            return FALSE;
        }

        // Add the default users_groups.
        $sql = "
            INSERT INTO `users_groups` (`id`, `user_id`, `group_id`)
            VALUES
                (1,1,1);
	    ";

        if(!$this->db->query($sql))
        {
            return FALSE;
        }

        // Add the default category.

        $sql = "
            INSERT INTO `categories` (`id`, `name`, `slug`, `discussion_count`, `comment_count`)
            VALUES
                (1,'General','general',0,0);
        ";

        if(!$this->db->query($sql))
        {
            return FALSE;
        }

        // Add the default language_pack
        $sql = "
            INSERT INTO `language_packs` (`id`, `language`, `code`, `icon`, `deletable`)
            VALUES
                (1,'English','english','gb.png',0),
                (2, 'Italian', 'italian', 'it.png', 0);
        ";

        if(!$this->db->query($sql))
        {
            return FALSE;
        }

        // Add the default permissions
        $sql = "
            INSERT INTO `permissions` (`permission_id`, `permission`, `key`, `category`)
            VALUES
                (1,'Create Discussions','create_discussions','discussions'),
                (2,'Edit Discussions','edit_discussions','discussions'),
                (3,'Delete Discussions','delete_discussions','discussions'),
                (4,'Create Comments','create_comments','comments'),
                (5,'Edit Comments','edit_comments','comments'),
                (6,'Delete Comments','delete_comments','comments'),
                (7,'Report Discussions','report_discussions','discussions'),
                (8,'Report Comments','report_comments','comments'),
                (9,'View Discussions','view_discussions','discussions'),
                (10,'Change Password','change_password','users'),
                (11,'Change Settings','change_settings','settings'),
                (12,'Report Users','report_users','users'),
                (13,'Edit User Settings','edit_user_settings','users'),
                (14,'View Profile','view_profile','users'),
                (15,'Unlock Achievements', 'unlock_achievements', 'achievements');
        ";

        if(!$this->db->query($sql))
        {
            return FALSE;
        }

        // Add the default permission_map
        $sql = "
            INSERT INTO `permission_map` (`group_id`, `permission_id`)
            VALUES
                (1,9),
                (1,14),
                (2,3),
                (2,2),
                (2,1),
                (2,4),
                (2,5),
                (2,6),
                (2,7),
                (2,8),
                (2,9),
                (2,10),
                (2,11),
                (2,12),
                (2,13),
                (2,14),
                (2,15),
                (3,1),
                (3,2),
                (3,4),
                (3,5),
                (3,7),
                (3,8),
                (3,9),
                (3,10),
                (3,12),
                (3,13),
                (3,14),
                (3,15);
        ";

        if(!$this->db->query($sql))
        {
            return FALSE;
        }

        // Add some default achievements.
        $sql = "
            INSERT INTO `achievements` (`id`, `name`, `description`, `points`) VALUES
                (1, 'Create your First Comment.', 'You have created your very first comment!', 5),
                (2, 'Create your First Discussion', 'You have created your very first discussion!', 5);
        ";

        if(!$this->db->query($sql))
        {
            return FALSE;
        }

        // Insert some default triggers.
        $sql = "
            INSERT INTO `achievement_triggers` (`id`, `action`, `condition`, `achievement_id`) VALUES
                (1, 'create_comment', '1', 1),
                (2, 'create_discussion', '1', 2);
        ";

        if(!$this->db->query($sql))
        {
            return FALSE;
        }

        // Everything ok.
        return TRUE;
    }

    public function edit_database_config($find, $replace)
    {
        $reading = fopen(APPPATH . 'config/database.php', 'r');
        $writing = fopen(APPPATH . 'config/database.tmp', 'w');

        $replaced = false;

        while (!feof($reading))
        {
            $line = fgets($reading);

            if (stristr($line, $find))
            {
                $line = $replace;
                $replaced = true;
            }
            fputs($writing, $line);
        }

        fclose($reading); fclose($writing);

        // Do not overwrite the file if we did not replace anything.
        if ($replaced)
        {
            rename(APPPATH . 'config/database.tmp', APPPATH . 'config/database.php');
            return true;
        }
        else
        {
            unlink(APPPATH . 'config/database.tmp');
            return false;
        }
    }

    public function edit_main_config($find, $replace)
    {
        $reading = fopen(APPPATH . 'config/config.php', 'r');
        $writing = fopen(APPPATH . 'config/config.tmp', 'w');

        $replaced = false;

        while (!feof($reading))
        {
            $line = fgets($reading);

            if (stristr($line, $find))
            {
                $line = $replace;
                $replaced = true;
            }
            fputs($writing, $line);
        }

        fclose($reading); fclose($writing);

        // Do not overwrite the file if we did not replace anything.
        if ($replaced)
        {
            rename(APPPATH . 'config/config.tmp', APPPATH . 'config/config.php');
            return true;
        }
        else
        {
            unlink(APPPATH . 'config/config.tmp');
            return false;
        }
    }

    public function edit_forum_config($find, $replace)
    {
        $reading = fopen(APPPATH . 'config/forums.php', 'r');
        $writing = fopen(APPPATH . 'config/forums.tmp', 'w');

        $replaced = false;

        while (!feof($reading))
        {
            $line = fgets($reading);

            if (stristr($line, $find))
            {
                $line = $replace;
                $replaced = true;
            }
            fputs($writing, $line);
        }

        fclose($reading); fclose($writing);

        // Do not overwrite the file if we did not replace anything.
        if ($replaced)
        {
            rename(APPPATH . 'config/forums.tmp', APPPATH . 'config/forums.php');
            return true;
        }
        else
        {
            unlink(APPPATH . 'config/forums.tmp');
            return false;
        }
    }

    public function edit_routes_config($find, $replace)
    {
        $reading = fopen(APPPATH . 'config/routes.php', 'r');
        $writing = fopen(APPPATH . 'config/routes.tmp', 'w');

        $replaced = false;

        while (!feof($reading))
        {
            $line = fgets($reading);

            if (stristr($line, $find))
            {
                $line = $replace;
                $replaced = true;
            }
            fputs($writing, $line);
        }

        fclose($reading); fclose($writing);

        // Do not overwrite the file if we did not replace anything.
        if ($replaced)
        {
            rename(APPPATH . 'config/routes.tmp', APPPATH . 'config/routes.php');
            return true;
        }
        else
        {
            unlink(APPPATH . 'config/routes.tmp');
            return false;
        }
    }

    public function test_database($host, $username, $password, $database_name)
    {
        // Create a connection.
        $conn = new mysqli($host, $username, $password, $database_name);

        // Check the connection.
        if ($conn->connect_error)
        {
            return FALSE;
        }

        return TRUE;
    }

}