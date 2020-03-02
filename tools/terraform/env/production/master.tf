provider "aws" {
  region  = var.aws_region
  profile = var.aws_profile
  version = "~> 2.1"
}

terraform {
  backend "s3" {
    # NOTE: need to create a s3 bucket and set bucket name
    # https://www.terraform.io/docs/backends/types/s3.html
    bucket = "laravel-starter-production-terraform-backend"
    key    = "terraform.tfstate"
    region = "us-west-1"
  }
}

// vpc
module "vpc" {
  source       = "../../modules/vpc"
  environment  = var.environment
  bu           = var.bu
  project_name = var.project_name
  stack_name   = var.stack_name
  vpc_cidr     = var.vpc_cidr
}

// database
module "rds" {
  source       = "../../modules/rds"
  environment  = var.environment
  bu           = var.bu
  project_name = var.project_name
  stack_name   = var.stack_name
  subnet_ids   = module.vpc.public_subnet_ids
  vpc_id       = module.vpc.vpc_id
}

// vm
module "ec2" {
  source       = "../../modules/ec2"
  environment  = var.environment
  bu           = var.bu
  project_name = var.project_name
  stack_name   = var.stack_name
  vpc_id       = module.vpc.vpc_id
  subnet_ids   = module.vpc.public_subnet_ids
  public_ips   = var.public_ips
}
