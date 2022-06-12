#!/usr/bin/env bash

mysql --user=root --password="$MYSQL_ROOT_PASSWORD" <<-EOSQL
    CREATE DATABASE IF NOT EXISTS ideasoft;
    GRANT ALL PRIVILEGES ON ideasoft.* TO '$MYSQL_USER'@'%';

    CREATE DATABASE IF NOT EXISTS ideasoft_testing;
    GRANT ALL PRIVILEGES ON ideasoft_testing.* TO '$MYSQL_USER'@'%';
EOSQL
