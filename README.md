# Git Users API

A Laravel API project

## Description

Git Users API is a simple project based on Laravel that provides an endpoint for fetching data on GitHub users by accepting their usernames as parameter and consuming GitHub's REST APIs

## Getting Started

For ease of use, environment config file (.env) is included in the repository.

### Dependencies

* Docker
* Composer
* PHP 7.4 +

### Installing

Clone the project through git
```
git clone https://github.com/jeffrey252/github_api.git
```
Set permissions on the project directory for your non-root user
```
sudo chown -R $USER:$USER github_api
```

### Setting up the API site

```
cd github_api
```
```
docker-compose up -d
composer install
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
Password should be 'qwer1234'
And then inside MySQL
```
GRANT ALL ON github_api.* TO 'admin'@'%' IDENTIFIED BY 'qwer1234';
FLUSH PRIVILEGES;
```
Exit from both MysQL and db container to migrate the database
```
docker-compose exec app php artisan migrate
docker-compose exec app php artisan passport:install
```

# API usage

## API Logs

You can view the API logs by accessing the app docker container
```
docker-compose exec app bash
```
The API log is saved in
`var/www/storage/logs/laravel-api.log`

```
[2021-08-21 03:03:15] local.INFO: Github API called for user: jeffrey252
[2021-08-21 03:03:17] local.INFO: Redis Cache accessed for user: jeffrey252
```
## User Registration

### Request
`POST /api/auth/signup`
```
curl -i -H 'Accept: application/json' -H 'X-Requested-With: XMLHttpRequest' -d 'name=sample&email=sampleemail@gmail.com&password=samplepassword&password_confirmation=samplepassword' http://localhost/api/auth/signup
```
### Response
```
HTTP/1.1 201 Created
Server: nginx/1.21.1
Content-Type: application/json
Transfer-Encoding: chunked
Connection: keep-alive
X-Powered-By: PHP/7.4.22
Cache-Control: no-cache, private
Date: Sat, 21 Aug 2021 02:25:36 GMT
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
Access-Control-Allow-Origin: *

{"message":"Successfully created user!"}
```

## User Login

### Request
`POST /api/auth/login`
```
curl -i -H 'Accept: application/json' -H 'X-Requested-With: XMLHttpRequest' -d 'email=sampleemail@gmail.com&password=samplepassword' http://localhost/api/auth/login
```
### Response
```
HTTP/1.1 200 OK
Server: nginx/1.21.1
Content-Type: application/json
Transfer-Encoding: chunked
Connection: keep-alive
X-Powered-By: PHP/7.4.22
Cache-Control: no-cache, private
Date: Sat, 21 Aug 2021 02:26:47 GMT
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
Access-Control-Allow-Origin: *

{"access_token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMTJmMGQ0MjBhNGNlNGZhMWJlYzYyODg1ZWEzNDVhMTYwZDE3ZTNiNTY2OTljMjBjZTg4MzYxZjEwODUzNGQwNzEzNjViMmVlZjY4NjllYmIiLCJpYXQiOjE2Mjk1MTI4MDcuNzM0MTMxLCJuYmYiOjE2Mjk1MTI4MDcuNzM0MTQsImV4cCI6MTY2MTA0ODgwNy42OTE1OTMsInN1YiI6IjIiLCJzY29wZXMiOltdfQ.xozPDwnq2-nnlM6MPYo8g232bt_n0OKkbMMNHDOOwirdducFURGIwSfmRWfJCOg_-aiLNozJ58OPZopkkWCbBPfDn2i-I-o2humEsoyvwXI45SQRjbG2wRIVGSOnd5oHMDjOUZ_esZqDBTtAcXltqIUp0n9C-x07LzfcTFmImVxVwXXjEc0RtGfontxkLTp5U6_8a0rckrVrdnd-YIPYRGVBdEUa7gYVs_0tAGl04h6tPPLDUFnTXZoRSkc6EKUvwSwlaTxHjaoTrFwbhdq7COlHKILSrnISwyjE7iYMXoZwnADzMB3DiSh_frZ_-J8jtHPGNnTmdyEdzt3vAjPsTX9KU7qW7ym9gVWDGg8MHBUEiMlxU1hvacXoUe0GSAXici_5cKpWpxdNztQndxUMRgncY3Vwcc_mxqSwcUmswBmFtEx3fCFOIOiWUKP8lTEvQEnA7y6OWfScUHVkw3w2tKcC05OYAxp34fiLf2P2tU6o4y1AQZl7VY8yp4Sw0hQKbWMI33pDiVb9LRyQkexUVhgIN7CI4KTo6UInliyMYa2VEXF-NDvgbTtMiI1Fp6S-bnfb4JtTmJ8hBjsyNlrL9oFuh4W6GM9i1tiGItBc29VV5Jeu6yqG-sHogW3Pv9d8IGWXEh1RqPhTmxJ9ve_bBCddjteOh-mmqZi7jVY1VqM","token_type":"Bearer","expires_at":"2022-08-21 02:26:47"}
```
After successfully consuming the login endpoint, take note of the access_token as you will have to include this value on when accessing endpoints that require it. Add Authorization on your headers with the value "Bearer {the access_token}"

## User Logout

### Request
`GET /api/auth/logout`
```
curl -i -H 'Accept: application/json' -H 'X-Requested-With: XMLHttpRequest' -H 'Authorization: {INSERT YOUR AUTHORIZATION TOKEN HERE}' http://localhost/api/auth/logout
```
### Response
```
HTTP/1.1 200 OK
Server: nginx/1.21.1
Content-Type: application/json
Transfer-Encoding: chunked
Connection: keep-alive
X-Powered-By: PHP/7.4.22
Cache-Control: no-cache, private
Date: Sat, 21 Aug 2021 02:30:04 GMT
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
Access-Control-Allow-Origin: *

{"message":"Successfully logged out"}
```
## Get Git Users v1

### Request
`POST /api/githubUsers`
```
curl -i -H 'Content-Type: application/json' -H 'X-Requested-With: XMLHttpRequest' -H 'Authorization : {YOUR_AUTHORIZATION_KEY_HERE}' -d '["jeffrey252", "amanda"]' http://localhost/api/githubUsers
```
### Response
```
HTTP/1.1 200 OK
Server: nginx/1.21.1
Content-Type: application/json
Transfer-Encoding: chunked
Connection: keep-alive
X-Powered-By: PHP/7.4.22
Cache-Control: no-cache, private
Date: Sat, 21 Aug 2021 02:39:46 GMT
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 57
Access-Control-Allow-Origin: *

[{"name":"Amanda Pickering","login":"amanda","company":null,"followers":32,"public_repos":39,"average_followers_per_public_repo":0.8205128205128205},{"name":"Jeff","login":"jeffrey252","company":null,"followers":0,"public_repos":2,"average_followers_per_public_repo":0}]
```

## Get Git Users v2

### Request
`GET /api/gusers?names={urlencodedvalues}`
```
curl -i -H 'Accept: application/json' -H 'X-Requested-With: XMLHttpRequest' -H 'Authorization: {YOUR_AUTHORIZATION_KEY_HERE}' http://localhost/api/gusers?names=jeffrey252%2Camanda
```
### Response
```
HTTP/1.1 200 OK
Server: nginx/1.21.1
Content-Type: application/jsonTransfer-Encoding: chunked
Connection: keep-alive
X-Powered-By: PHP/7.4.22
Cache-Control: no-cache, private
Date: Sat, 21 Aug 2021 02:32:37 GMT
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 59
Access-Control-Allow-Origin: *

[{"name":"Amanda Pickering","login":"amanda","company":null,"followers":32,"public_repos":39,"average_followers_per_public_repo":0.8205128205128205},{"name":"Jeff","login":"jeffrey252","company":null,"followers":0,"public_repos":2,"average_followers_per_public_repo":0}]
```

# Hamming Distance

For this challenge, I created basic endpoints for handling the request
`GET /api/hamming/v1?x=1&x=4`
`GET /api/hamming/v2?x=1&x=4`
These endpoints should be viewable directly in the browser.

The v1 endpoint mostly utilized built-in array and string functions from PHP while the v2 is a more manual approach.
The v2 endpoint however has a bit of a more detailed output