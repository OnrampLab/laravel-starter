# Environment
environment = "Staging"

# Your AWS CLI profile
aws_profile = "default"

# The default region for your Terraform infrastructure
aws_region = "us-west-1"

# Your project's name
project_name = "Laravel Starter"
stack_name   = "laravel-starter-staging"

# Your business unit
bu = "General"

vpc_cidr = "10.1.0.0/16"

# Optional Elastic IPs you want to use
public_ips = {
  production = ""
  default    = ""
}
