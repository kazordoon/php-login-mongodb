
# php-login-mongodb
Login with PHP and MongoDB.

## Getting Started

- Clone the repository: `git clone https://github.com/kazordoon/php-login-mongodb.git`
- Get in the project directory: `cd php-login-mongodb`

### Prerequisites
- Docker
- Docker Compose

### Run containers
- `docker-composer up -d`

### Run the MongoDB script
- `docker exec -i php_login_db mongo -u root -p toor < src/database/script`

## Versioning

For the versions available, see the [tags on this repository](https://github.com/kazordoon/php-login-mongodb/tags). 

## Authors

* **Felipe Barros** - *Initial work* - [kazordoon](https://github.com/kazordoon)

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details

