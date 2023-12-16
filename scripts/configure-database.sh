#!/bin/bash
docker container exec -i php_login_db mongosh -u root -p toor --authenticationDatabase admin php_login --eval "
db.users.createIndex({ email: 1 }, { unique: 1 });
db.createUser({ user: 'php', pwd: 'phppass', roles: [ { role: 'readWrite', db: 'php_login' } ] });
"
