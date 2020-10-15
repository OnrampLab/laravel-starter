# EKS Terraform module

terraform {
  backend "s3" {
    # NOTE: need to create a s3 bucket and set bucket name
    # https://www.terraform.io/docs/backends/types/s3.html
    bucket = "larave-starter-production-terraform-backend"
    key    = "terraform.tfstate"
    region = "us-east-1"
  }
}

module "eks" {
  source                   = "../../modules/eks"

  aws-region               = "us-east-1"
  availability-zones       = ["us-east-1a", "us-east-1b", "us-east-1c"]
  cluster-name             = "larave-starter-production-eks-cluster"
  k8s-version              = "1.17"
  node-instance-type       = "m4.large"
  desired-capacity         = 1
  max-size                 = 5
  min-size                 = 1
  vpc-subnet-cidr          = "11.0.0.0/16"
  private-subnet-cidr      = ["11.0.0.0/19", "11.0.32.0/19", "11.0.64.0/19"]
  public-subnet-cidr       = ["11.0.128.0/20", "11.0.144.0/20", "11.0.160.0/20"]
  db-subnet-cidr           = ["11.0.192.0/21", "11.0.200.0/21", "11.0.208.0/21"]
  eks-cw-logging           = ["api", "audit", "authenticator", "controllerManager", "scheduler"]
  ec2-key-public-key       = "ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQC1BE8F6aGssVEvPegj8ssc2L8nhsE/pUt4WklrJ2T2plkXCmKE0/tabmysHD5uxUBCi1Bqkji5PtAZVCSn4BRXBQZw0CSAQyC8brXNajKtK9f76uErDknspVDBP+AeUCp+ur+FXppQLCWAIP1cKWqTBNGzkC8hsqIRAyTO5nmWvCdBcOzM65rvyQGhb9rkX+3UpdqC0jX8shbHSKjCrhCMI5bpnjnfYLbNSVd72cXeyNmWmofnvxEp9OOJLAJeWioCcK3RdeU45kELtCCTTTf5r1KojN13jOBAEabifPQj35C/ndSPSFybfHpRKO12p3kV0bnu+fNqwaYllHRQCmVz email@example.com"
  project_name             = "larave-starter"
  stack_name               = "larave-starter-production"
  bu                       = "Performance Marketing"
  environment              = "Production"
}
