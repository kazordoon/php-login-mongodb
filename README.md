# php-login-mongodb
Login with PHP using MongoDB as database.

## Getting Started

### Prerequisites
- Docker
- Docker Compose

### Installation
- Clone the repository: `git clone https://github.com/kazordoon/php-login-mongodb.git`
- Get in the project directory: `cd php-login-mongodb`
- Run the containers: `docker-composer up -d`
- Run the script to configure the database: `./scripts/configure-database.sh`
- Run the script to install the PHP dependencies: `./scripts/install-php-dependencies.sh`

## Configuration
- Edit the `src/config/config.inc.php` file, changing the constants `MAIL_*`

After the configuration, access the following URL at the browser: [http://localhost:8080/](http://localhost:8080/)

## Built with
- [PHP 8.1](https://www.php.net/)
	- [coffeecode/router](https://packagist.org/packages/coffeecode/router)
	- [twig/twig](https://packagist.org/packages/twig/twig)
	- [mongodb/mongodb](https://packagist.org/packages/mongodb/mongodb)
	- [phpmailer/phpmailer](https://packagist.org/packages/phpmailer/phpmailer)
- [MongoDB](https://www.mongodb.com/)

## Versioning

For the versions available, see the [tags on this repository](https://github.com/kazordoon/php-login-mongodb/tags). 

## Authors

* **Felipe Barros** - *Initial work* - [kazordoon](https://github.com/kazordoon)

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details

