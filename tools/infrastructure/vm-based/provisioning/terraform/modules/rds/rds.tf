data "aws_region" "current" {}
data "aws_availability_zones" "available" {}

data "aws_vpc" "vpc" {
  id = var.vpc_id
}

locals {
  nb_azs = length(data.aws_availability_zones.available.names)
}

resource "random_string" "rds_master_password" {
  length           = 16
  special          = true
  override_special = "!#$%&*()-_=+[]{}<>:?"
}

resource "random_string" "final_snapshot_id" {
  length  = 24
  special = false
}

resource "aws_db_subnet_group" "mysql_subnet_group" {
  name       = "mysql_db_subnet_group_${var.stack_name}_${terraform.workspace}"
  subnet_ids = var.subnet_ids

  tags = {
    Name        = "${var.project_name} Subnet Group ${var.environment}"
    BU          = var.bu
    Project     = var.project_name
    Environment = var.environment
    "AWS Type"  = "Subnet Group"
  }
}

resource "aws_security_group" "db_security_group" {
  name   = "${var.project_name} DB ASG ${var.environment}"
  vpc_id = data.aws_vpc.vpc.id

  ingress {
    from_port   = 3306
    to_port     = 3306
    protocol    = "TCP"
    cidr_blocks = [data.aws_vpc.vpc.cidr_block]
  }

  tags = {
    Name            = "${var.project_name} DB ASG ${var.environment}"
    BU              = var.bu
    Project         = var.project_name
    Environment     = var.environment
    "Instance Name" = "${var.project_name} DB ASG ${var.environment}"
    "AWS Type"      = "Security Group"
  }
}

resource "aws_db_instance" "mysql_db_instance" {
  count                = 1
  identifier           = "${var.stack_name}-${count.index + 1}"
  skip_final_snapshot  = true
  allocated_storage    = 20
  instance_class       = "db.t2.small"
  db_subnet_group_name = aws_db_subnet_group.mysql_subnet_group.name
  publicly_accessible  = false
  engine               = "mysql"
  engine_version       = "8.0"
  username             = "mr_admin"
  password             = random_string.rds_master_password.result

  vpc_security_group_ids = [
    aws_security_group.db_security_group.id,
  ]

  tags = {
    Name            = "${var.project_name} RDS ${var.environment}"
    BU              = var.bu
    Project         = var.project_name
    Environment     = var.environment
    "Instance Name" = "${var.project_name} RDS ${var.environment}"
    "AWS Type"      = "RDS Instance"
  }
}
