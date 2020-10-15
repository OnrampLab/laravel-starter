
resource "random_string" "rds_master_password" {
  length           = 16
  special          = true
  override_special = "!#$%&*()-_=+[]{}<>:?"
}

module "db" {
  source  = "terraform-aws-modules/rds/aws"
  version = "~> 2.0"

  identifier = "${var.stack_name}-db"

  engine            = "mysql"
  engine_version    = "8.0"
  instance_class    = "db.t2.small"
  allocated_storage = 20

  name     = "laravel-starter"
  username = "admin"
  password = random_string.rds_master_password.result
  port     = "3306"

  iam_database_authentication_enabled = true

  vpc_security_group_ids = [data.aws_security_group.node.id]

  maintenance_window = "Mon:00:00-Mon:03:00"
  backup_window      = "03:00-06:00"

  # Enhanced Monitoring - see example for details on how to create the role
  # by yourself, in case you don't want to create it automatically
  # monitoring_interval = "30"
  # monitoring_role_name = "MyRDSMonitoringRole"
  # create_monitoring_role = true

  tags = {
    Name            = "${var.project_name} RDS ${var.environment}"
    BU              = var.bu
    Project         = var.project_name
    Environment     = var.environment
    "Instance Name" = "${var.project_name} RDS ${var.environment}"
    "AWS Type"      = "RDS Instance"
  }

  # DB subnet group
  subnet_ids = data.aws_subnet_ids.private.ids

  # DB parameter group
  family = "mysql8.0"

  # DB option group
  major_engine_version = "8.0"

  # Snapshot name upon DB deletion
  final_snapshot_identifier = var.stack_name

  # Database Deletion Protection
  deletion_protection = true

  skip_final_snapshot = true

  parameters = [
    {
      name  = "character_set_client"
      value = "utf8"
    },
    {
      name  = "character_set_server"
      value = "utf8"
    }
  ]

  # options = [
  #   {
  #     option_name = "MARIADB_AUDIT_PLUGIN"

  #     option_settings = [
  #       {
  #         name  = "SERVER_AUDIT_EVENTS"
  #         value = "CONNECT"
  #       },
  #       {
  #         name  = "SERVER_AUDIT_FILE_ROTATIONS"
  #         value = "37"
  #       },
  #     ]
  #   },
  # ]
}
