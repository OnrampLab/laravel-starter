# laravel-starter

為了讓公司有統一的 coding style 以及方便開始一個新專案並套用我們的 best practice，所以希望可以建立一個 github repo 符合下面的幾個 best practices

* 最新的 Laravel (8.x)
  * 以 feature 當一個 module
  * 有 local composer packages
* Useful Laravel packages
  * owen-it/laravel-auditing: handle entity change logs
* DevOps Tools
  * Development Environment
    * Docker (phpmyadmin, mysql)
  * Provisioning tools
    * Terraform (AWS VPC, RDS, EC2)
    * Ansible
  * Deployment tools
    * Capistrano
  * CI (CircleCI)
    * Static Code Analysis
    * Unit Testing
* 系統需求：
  * nvm
  * yarn
  * phpbrew

## Application Architecture

### App
  * 內建 `laravel-modules` 支援
  * 內建 `horizon` 支援
  * 內建 `laravel-cors` 支援
  * 整合 `l5-repository` ，方便建立 `Repository`

### Modules
  * Account
    * 提供多帳號的支援，每個帳號可以擁有各自的使用者
  * Auth
    * 使用者管理
    * JWT 登入
    * 使用 `laravel-permission` 做權限處理
  * Core
    * 提供核心自訂的框架元件，像是內建支援 `Audit` 功能

## laravel-modules Commands

### Create a module
假設要建立一個 `Blog` module，可以執行

```bash
php artisan module:make Blog
```

## local packages
如果要建立一個 package `auth-util`，範例如下

1. 建立檔案 packages/auth-util/composer.json
```json
{
    "name": "onramplab-utils/auth-util",
    "require": {
    },
    "autoload": {
        "psr-4": {
            "AuthUtil\\": "src/"
        }
    },
    "extra": {
        "branch-alias": {
            "dev-master": "1.0-dev"
        },
        "laravel": {
            "providers": [
                "OnrampLab\\AuthUtil\\AuthUtilServiceProvider"
            ]
        }
    },
    "config": {
        "sort-packages": true
    },
    "prefer-stable": true,
    "minimum-stability": "dev"
}
```

2. 將 `auth-util` 加到 `require` 與 `repositories` block
```json
"require": {
    "php": "^7.1.3",
    "fideloper/proxy": "^4.0",
    "laravel/framework": "5.8.*",
    "laravel/tinker": "^1.0",
    "nwidart/laravel-modules": "^5.0",
    "onramplab-lib/auth-util": "^1.0@dev"
},
...
"repositories": [
    {
        "type": "path",
        "url": "packages/auth-util"
    }
],
```

3. 安裝 package
```bash
composer require onramplab-lib/auth-util
```

## Development environment with Docker
1. Update `.env` file with for docker
1. run `docker-compose up`

## Infrastructure
### VM-based
Provisioning and ochestration for VM-based infrastructure, please refer to [vm-based infrastructure](tools/infrastructure/vm-based/README.md)

### How to trigger CircleCI to deploy
1. You will need to set up a deploy key for CircleCI to have git permission
1. You will need to set up a ssh private key for CircleCI to deploy
1. Tag a version
  1. Run `npm version patch`, `npm version minor` or `npm major` to tag a version
  1. Push your new commits with `git push --follow-tags`
