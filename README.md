# Git Users API

A Laravel API project

## Description

Git Users API is a simple project based on Laravel that provides an endpoint for fetching data on GitHub users by accepting their usernames as parameter and consuming GitHub's REST APIs

## Getting Started

### Dependencies

* Docker
* Composer

### Installing

Clone the project through git
```
git clone https://github.com/jeffrey252/github_api.git
```
Set permissions on the project directory for your non-root user
```
sudo chown -R $USER:$USER github_api
```

### Executing program

```
composer install
```
```
docker-compose up -d
```
```
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan config:cache
docker-compose exec db bash
```
Inside the db container
```
mysql -u root -p
```
Inside MySQL
```
GRANT ALL ON github_api.* TO 'admin'@'%' IDENTIFIED BY 'qwer1234';
FLUSH PRIVILEGES;
```
Exit from both MysQL and db container to migrate the database
```
docker-compose exec app php artisan migrate
```

## Help

Any advise for common problems or issues.
```
command to run if program contains helper info
```

## Authors

Contributors names and contact info

ex. Dominique Pizzie  
ex. [@DomPizzie](https://twitter.com/dompizzie)

## Version History

* 0.2
    * Various bug fixes and optimizations
    * See [commit change]() or See [release history]()
* 0.1
    * Initial Release

## License

This project is licensed under the [NAME HERE] License - see the LICENSE.md file for details

## Acknowledgments

Inspiration, code snippets, etc.
* [awesome-readme](https://github.com/matiassingers/awesome-readme)
* [PurpleBooth](https://gist.github.com/PurpleBooth/109311bb0361f32d87a2)
* [dbader](https://github.com/dbader/readme-template)
* [zenorocha](https://gist.github.com/zenorocha/4526327)
* [fvcproductions](https://gist.github.com/fvcproductions/1bfc2d4aecb01a834b46)