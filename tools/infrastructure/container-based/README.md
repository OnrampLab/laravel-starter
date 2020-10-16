# container-based infrastructure

## Provisioning
### Install Terraform
至 https://www.terraform.io/downloads.html 下載並安裝

### Create AWS S3 Bucket

https://www.terraform.io/docs/backends/types/s3.html

update bucket name in your master.tf for the env (e.g. tools/infrastructure/container-based/provisioning/terraform/env/production)

### Create ECR Repository

Follow the document to create a ECR Repository: https://docs.aws.amazon.com/AmazonECR/latest/userguide/repository-create.html

For example, create a repository called `laravel-starter`.

### Init terraform
```
cd tools/infrastructure/container-based/provisioning/terraform/env/production
terraform init
```

### Start provisioning
```
cd tools/infrastructure/container-based/provisioning/terraform/env/production
terraform apply
```

## Deployment
### Requirements
#### Install kubectl

https://kubernetes.io/docs/tasks/tools/install-kubectl/

#### Install kustomize

https://kubernetes-sigs.github.io/kustomize/installation/

### Manaul Deployment by kubernetes
#### Change to cluster of staging or production
```
aws eks --region us-east-1 update-kubeconfig --name CLUSTER_NAME
```

#### Build docker image
```
CIRCLE_TAG=1.0.1

echo "building docker image: 'laravel-starter:${CIRCLE_TAG}'"
docker build --target php-prod -t laravel-starter:${CIRCLE_TAG} .

echo "uploading docker image to ECR..."
aws ecr get-login-password --region us-east-1 | docker login --username AWS --password-stdin AWS_ACCOUNT_ID.dkr.ecr.us-east-1.amazonaws.com/laravel-starter

docker tag laravel-starter:${CIRCLE_TAG} AWS_ACCOUNT_ID.dkr.ecr.us-east-1.amazonaws.com/laravel-starter:${CIRCLE_TAG}

docker push AWS_ACCOUNT_ID.dkr.ecr.us-east-1.amazonaws.com/laravel-starter:${CIRCLE_TAG}
```


#### Command for deploy
```bash
root=$(pwd)
ENVIRONMENT=production
CIRCLE_TAG=1.0.1

echo "applying changes to k8s cluster..."
cd ${root}/tools/infrastructure/container-based/ochestration/kubernetes/bases
kustomize edit set image "laravel-starter=AWS_ACCOUNT_ID.dkr.ecr.us-east-1.amazonaws.com/laravel-starter:${CIRCLE_TAG}"

cd ${root}/tools/infrastructure/container-based/ochestration/kubernetes/${ENVIRONMENT}/bases
kustomize build | kubectl apply -f -
```
