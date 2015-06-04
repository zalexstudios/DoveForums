# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased][unreleased]
### Changed

## [0.3.0] - 2015-06-04
### Changed
- controllers/Discussions.php - Added permission checks.
- controllers/Comments.php - Added permission checks.
- controllers/Users.php - Added permission checks.
- language/english/forums_lang.php - Added new error message for permissions system.

### Added
- libraries/Permission.php - Added a simple group based permissions system.
- models/Install_m.php - Added more sql to create permissions and permission_map table along with default data.


## [0.2.0] - 2015-06-02
### Changed
- core/MY_Controller, changed version number for minor feature additions.
- language/english/forums_lang.php, added additional language files for new pages.
- models/Install_m.php, updated the users table creation.
- models/Install_m.php, updated language packs sql to include italian by default.
- controllers/Install.php, Updated the install process to allow users to pick the sites default language.
- templates/install/settings.php, Added the language dropdown box.

### Added
- templates/default/pages/users/profile.php
- models/Forums_m.php - Added count_user_discussions($user_id) function.
- models/Forums_m.php - Added count_user_comments($user_id) function.
- controllers/Users.php - Added profile function.
- controllers/Users.php - Added settings function.
- controllers/Users.php - Added report function.
- templates/default/pages/users/settings.php
- templates/default/pages/users/report.php

## [0.0.1] - 2015-06-02
### Changed
- controllers/Forums.php, updated any static text to come from language file.
- controllers/Categories.php, updated any static text to come from language file.
- controllers/Comments.php, updated any static text to come from language file.
- controllers/Dashboard.php, updated any static text to come from language file.
- controllers/Users.php, updated any static text to come from language file.
- language/english/forums_lang.php, added some more updates.
- templates/default/pages/home/home.php, added <?= lang(''); ?> calls where static text was present.
- templates/default/pages/categories/all.php added <?= lang(''); ?> calls where static text was present.
- templates/default/pages/categories/view/php added <?= lang(''); ?> calls where static text was present.
- templates/default/pages/comments/edit.php <?= lang(''); ?> calls where static text was present.
- templates/default/pages/comments/report.php <?= lang(''): ?> calls where static text was present.
- templates/default/pages/dashboard/dashboard.php <?= lang(''): ?> calls where static text was present.
- templates/default/pages/dashboard/users.php <?= lang(''): ?> calls where static text was present.
- templates/default/pages/dashboard/add_user.php <?= lang(''): ?> calls where static text was present.
- templates/default/pages/dashboard/edit_user.php <?= lang(''): ?> calls where static text was present.
- templates/default/pages/dashboard/groups.php <?= lang(''): ?> calls where static text was present & updated template link.
- templates/default/pages/dashboard/add_edit_group.php <?= lang(''): ?> calls where static text was present.
- templates/default/pages/dashboard/categories.php <?= lang(''): ?> calls where static text was present & updated template link.
- templates/default/pages/dashboard/add_category.php <?= lang(''): ?> calls where static text was present.
- templates/default/pages/dashboard/edit_category.php <?= lang(''): ?> calls where static text was present.
- templates/default/pages/dashboard/discussions.php <?= lang(''): ?> calls where static text was present & updated template link.
- templates/default/pages/dashboard/edit_discussion.php <?= lang(''): ?> calls where static text was present.
- templates/default/pages/dashboard/settings.php <?= lang(''): ?> calls where static text was present.
- templates/default/pages/dashboard/language_packs.php <?= lang(''): ?> calls where static text was present.
- templates/default/pages/dashboard/add_edit_language.php <?= lang(''): ?> calls where static text was present.
- templates/default/pages/discussions/view.php <?= lang(''): ?> calls where static text was present.
- templates/default/pages/discussions/reply.php <?= lang(''): ?> calls where static text was present.
- templates/default/pages/discussions/new.php <?= lang(''): ?> calls where static text was present.
- templates/default/pages/discussions/edit.php <?= lang(''): ?> calls where static text was present.
- templates/default/pages/discussions/report.php <?= lang(''): ?> calls where static text was present.
- templates/default/pages/users/register.php <?= lang(''): ?> calls where static text was present.
- templates/default/pages/users/login.php <?= lang(''): ?> calls where static text was present.
- templates/default/pages/users/change_password.php <?= lang(''): ?> calls where static text was present.
- templates/default/pages/users/forgot_password.php <?= lang(''): ?> calls where static text was present.
- templates/default/pages/users/reset_password.php <?= lang(''): ?> calls where static text was present.
### Renamed
- templates/default/pages/dashboard/all_groups.php to templates/default/pages/dashboard/groups.php
- templates/default/pages/dashboard/all_categories.php to templates/default/pages/dashboard/categories.php
- templates/default/pages/dashboard/all_discussions.php to templates/default/pages/dashboard/discussions.php