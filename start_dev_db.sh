#!/bin/bash

cd /home/fabien/Documents/fastwork/laravel-dev/docker/shared-mariadb-tmpfs

docker compose up -d --no-recreate 

sleep 3

# shared-mariadb-tmpfs-db-1
docker exec -i shared-mariadb-tmpfs-db-1 sh -c 'exec mariadb -uroot -p"$MARIADB_ROOT_PASSWORD" -e "CREATE DATABASE lamal"'

