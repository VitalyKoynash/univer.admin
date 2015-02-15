http://bootstrap-ru.com/204/base_css.php

1 install 

(http://www.yiiframework.com/doc-2.0/guide-tutorial-advanced-app.html)
composer global require "fxp/composer-asset-plugin:1.0.0-beta4"
composer create-project --prefer-dist yiisoft/yii2-app-advanced yii-application

Getting started

After you install the application, you have to conduct the following steps to initialize the installed application. You only need to do these once for all.

    Execute the init command and select dev as environment.

    php /path/to/yii-application/init

    Otherwise, in production execute init in non-interactive mode.

    php /path/to/yii-application/init --env=Production --overwrite=All
    Create a new database and adjust the components.db configuration in common/config/main-local.php accordingly.
    Apply migrations with console command yii migrate.
    Set document roots of your web server:

    for frontend /path/to/yii-application/frontend/web/ and using the URL http://frontend/
    for backend /path/to/yii-application/backend/web/ and using the URL http://backend/

To login into the application, you need to first sign up, with any of your email address, username and password. Then, you can login into the application with same email address and password at any time.


2  add table for user
yii migrate --migrationPath=@yii/rbac/migrations

3 install mdmsoft/yii2-admin
 конфигурировать не в  common
Either run
	php composer.phar require mdmsoft/yii2-admin "~1.0"
for dev-master
	php composer.phar require mdmsoft/yii2-admin "dev-master"

run
	yii migrate --migrationPath=@vendor/mdmsoft/yii2-admin/migrations

	To use menu manager (optional). Execute yii migration here: 
	yii migrate --migrationPath=@mdm/admin/migrations

	If You use database (class 'yii\rbac\DbManager') to save rbac data. Execute yii migration here: 
	yii migrate --migrationPath=@yii/rbac/migrations


	for use menu
	http://mdmsoft.github.io/yii2-admin/index.html

	http://mdmsoft.github.io/yii2-admin/guide-using-menu.html
~~~~~~~~~~~~~~~~~~~~~~~~~

migrations			https://github.com/yiisoft/yii2/blob/master/docs/guide/db-migrations.md


for russian in pdf
https://github.com/kartik-v/yii2-mpdf/issues/1
$ config ['mode'] = Pdf :: MODE_UTF8;

kartik-v grid пергружает страницу при переключении All/Pages
добавить 'data-pjax'=>1 в функции renderToggleData() в строке 1166
