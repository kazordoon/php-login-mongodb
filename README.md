
# php-login-mongodb
Login with PHP and MongoDB.

## Getting Started

- Clone the repository: `git clone https://github.com/kazordoon/php-login-mongodb.git`
- Get in the project directory: `cd php-login-mongodb`

### Prerequisites
- Docker

### Build images
- MongoDB: `docker build -t mongo-php src/database`
- PHP: `docker build -t php-login .`

### Run containers
- MongoDB: `docker run --name mongo-php -p 27017:27017 -d mongo-php`
- PHP: `docker run --name php-login -p 8080:80 -v ./src:/var/www/html --link mongo-php -d php-login`

### Create an user into MongoDB
`docker exec -i mongo-php mongo -u root -p toor < src/database/script`

## Versioning

For the versions available, see the [tags on this repository](tags). 

## Authors

* **Felipe Barros** - *Initial work* - [kazordoon](https://github.com/kazordoon)

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details

