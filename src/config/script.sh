#!/bin/bash
docker container exec -i php_login_db mongo -uroot -ptoor < $PWD/mongo_script
