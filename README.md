Installation:

vhost einrichten

git clone https://github.com/dev-null-or-trash-bin/blackbox.git

composer.phar update

php app/console assets:install web

php app/console doctrine:database:create

php app/console doctrine:schema:update --force

php app/console fos:user:create --super-admin