#!/usr/bin/env bash

set -ex;

mysql.server start

## Get config.
if [ -f "$(pwd)/config.json" ]; then
    DB_USER=$(cat $(pwd)/config.json | jq -r ".mysql.username")
    DB_PASS=$(cat $(pwd)/config.json | jq -r ".mysql.password")
    DB_NAME=$(cat $(pwd)/config.json | jq -r ".mysql.database")
    DB_HOST=$(cat $(pwd)/config.json | jq -r ".mysql.host")

    PORT=$(cat $(pwd)/config.json | jq -r ".server.port")

    WP_TITLE=$(cat $(pwd)/config.json | jq -r ".wp.title")
    WP_LANG=$(cat $(pwd)/config.json | jq -r ".wp.lang")
    WP_ADMIN_USER=$(cat $(pwd)/config.json | jq -r ".wp.admin.user")
    WP_ADMIN_PASSWORD=$(cat $(pwd)/config.json | jq -r ".wp.admin.password")
    WP_ADMIN_EMAIL=$(cat $(pwd)/config.json | jq -r ".wp.admin.email")
else
    echo "config.json is NOT a file."
    exit 0
fi

WP_DESC="Hello World!"
DOC_ROOT=$(pwd)/www
WP_PATH=$(pwd)/www

## Start Server if installed.
if [ ! $(vendor/wp-cli/wp-cli/bin/wp core is-installed) ]; then

    ## Install WordPress.
    if [ $DB_PASS ]; then
        echo "DROP DATABASE IF EXISTS $DB_NAME;" | mysql -u$DB_USER -p$DB_PASS
        echo "CREATE DATABASE $DB_NAME DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;" | mysql -u$DB_USER -p$DB_PASS
    else
        echo "DROP DATABASE IF EXISTS $DB_NAME;" | mysql -u$DB_USER
        echo "CREATE DATABASE $DB_NAME DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;" | mysql -u$DB_USER
    fi

    vendor/wp-cli/wp-cli/bin/wp core install \
    --url=http://127.0.0.1:$PORT \
    --title="$WP_TITLE" \
    --admin_user="$WP_ADMIN_USER" \
    --admin_password="$WP_ADMIN_PASSWORD" \
    --admin_email="$WP_ADMIN_EMAIL"

    vendor/wp-cli/wp-cli/bin/wp rewrite structure "/archives/%post_id%"

    vendor/wp-cli/wp-cli/bin/wp option update blogname "$WP_TITLE"
    vendor/wp-cli/wp-cli/bin/wp option update blogdescription "$WP_DESC"

    if [ $WP_LANG ]; then
    vendor/wp-cli/wp-cli/bin/wp core language install $WP_LANG
    vendor/wp-cli/wp-cli/bin/wp core language activate $WP_LANG
    fi

    vendor/wp-cli/wp-cli/bin/wp plugin activate --all

    if [ -e "provision-post.sh" ]; then
        bash provision-post.sh
    fi

fi

## Open Server
open http://127.0.0.1:$PORT
vendor/wp-cli/wp-cli/bin/wp server --host=0.0.0.0 --port=$PORT --docroot=$DOC_ROOT
