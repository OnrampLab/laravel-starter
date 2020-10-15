### VPC

module "vpc" {
  source  = "terraform-aws-modules/vpc/aws"
  version = "2.7.0"

  name = "${var.cluster-name}-vpc"

  cidr = var.vpc-subnet-cidr

  azs              = var.availability-zones
  private_subnets  = var.private-subnet-cidr
  public_subnets   = var.public-subnet-cidr
  database_subnets = var.db-subnet-cidr

  create_database_subnet_group = true

  enable_dns_hostnames = true
  enable_dns_support   = true

  enable_nat_gateway = true

  tags = {
    "kubernetes.io/cluster/${var.cluster-name}" = "shared"
    Name                                        = "${var.cluster-name}-vpc"
    BU                                          = var.bu
    Project                                     = var.project_name
    Environment                                 = var.environment
    "AWS Type"                                  = "VPC"
  }

  public_subnet_tags = {
    Name                                        = "${var.cluster-name}-eks-public"
    "kubernetes.io/cluster/${var.cluster-name}" = "shared"
    "kubernetes.io/role/elb"                    = 1
    BU                                          = var.bu
    Project                                     = var.project_name
    Environment                                 = var.environment
    "AWS Type"                                  = "Subnet"
  }
  private_subnet_tags = {
    Name                                        = "${var.cluster-name}-eks-private"
    "kubernetes.io/cluster/${var.cluster-name}" = "shared"
    "kubernetes.io/role/internal-elb"           = 1
    BU                                          = var.bu
    Project                                     = var.project_name
    Environment                                 = var.environment
    "AWS Type"                                  = "Subnet"
  }
  database_subnet_tags = {
    Name        = "${var.cluster-name}-eks-db"
    BU          = var.bu
    Project     = var.project_name
    Environment = var.environment
    "AWS Type"  = "Subnet"
  }
}
