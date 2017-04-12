# A simple GitHub application with Laravel 5.4

## Getting Started

First, clone the repo:
```bash
$ git clone git@github.com:hasib32/laravel-git.git
```

#### Install dependencies
```
$ cd rest-api-with-lumen
$ composer install
```

#### Configure the Environment
Create `.env` file:
```
$ cat .env.example > .env
```
### [Create a new OAuth Application](https://github.com/settings/applications/new)

Create GitHub OAuth application If you don't have one. Then, update `.env`

```
GITHUB_CLIENT_ID=
GITHUB_SECRET=
GITHUB_REDIRECT_URL=
```
