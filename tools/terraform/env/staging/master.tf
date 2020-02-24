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
