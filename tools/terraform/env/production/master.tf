terraform {
  backend "s3" {
    # NOTE: need to create a s3 bucket and set bucket name
    # https://www.terraform.io/docs/backends/types/s3.html
    bucket = "laravel-starter-production-terraform-backend"
    key    = "terraform.tfstate"
    region = "us-west-1"
  }
}

// base
module "base" {
  source       = "../base"
  environment  = var.environment
  aws_region   = var.aws_region
  aws_profile  = var.aws_profile
  bu           = var.bu
  project_name = var.project_name
  stack_name   = var.stack_name
  vpc_cidr     = var.vpc_cidr
  public_ips   = var.public_ips
}
