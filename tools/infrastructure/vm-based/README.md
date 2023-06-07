# vm-based infrastructure

## Provisioning
### Install Terraform
至 https://www.terraform.io/downloads.html 下載並安裝

### Install Ansible
https://docs.ansible.com/ansible/latest/installation_guide/intro_installation.html

and then install requirements

```
cd tools/infrastructure/vm-based/provisioning/ansible
ansible-galaxy install -r requirements.yml
```

### Create AWS S3 Bucket

https://www.terraform.io/docs/backends/types/s3.html

update bucket name in your master.tf for the env (e.g. tools/infrastructure/vm-based/provisioning/terraform/env/production)

### Init terraform
```
cd tools/infrastructure/vm-based/provisioning/terraform/env/production
terraform init
```

### Start provisioning
```
cd tools/infrastructure/vm-based/provisioning/terraform/env/production
terraform apply
```

## Deployment
### Requirements

#### Server Requirememts
1. 建立 `/opt/www`
```bash
sudo mkdir /opt/www
sudo chown ubuntu:ubuntu /opt/www
```
1. 安裝 phpbrew, php
1. 安裝 nvm, node, yarn

#### Local Requirements
##### Install ruby & gems
1. local 環境需要先安裝好 `ruby` 環境
1. 執行
```bash
gem install bundler
bundle install
```


### Command for deploy
Deploy 到 production
```bash
CI_BRANCH=main cap production deploy
```
