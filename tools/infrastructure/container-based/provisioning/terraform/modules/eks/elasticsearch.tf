resource "aws_security_group" "es" {
  name        = "${var.stack_name}-elasticsearch-sg"
  description = "Allow EKS Cluster VPC to access ElasticSearch"
  vpc_id      = data.aws_vpc.eks.id

  ingress {
    from_port = 443
    to_port   = 443
    protocol  = "tcp"

    cidr_blocks = [
      data.aws_vpc.eks.cidr_block,
    ]
  }
}

module "aws_es" {

  source = "git::https://github.com/lgallard/terraform-aws-elasticsearch.git"

  domain_name           = "${var.stack_name}-elasticsearch"
  elasticsearch_version = "7.7"

  cluster_config = {
    dedicated_master_enabled = "true"
    dedicated_master_type    = "t2.small.elasticsearch"
    instance_count           = "1"
    instance_type            = "t2.small.elasticsearch"
    zone_awareness_enabled   = "false"
    availability_zone_count  = "1"
  }

  vpc_options = {
    subnet_ids = [
      sort(data.aws_subnet_ids.private.ids)[0]
    ]

    security_group_ids = [aws_security_group.es.id]
  }

  access_policies = templatefile("${path.module}/elasticsearch-whitelist.tpl", {
    region      = data.aws_region.current.name,
    account     = data.aws_caller_identity.current.account_id,
    domain_name = "${var.stack_name}-elasticsearch"
  })

  create_service_link_role = "false"

  ebs_options = {
    ebs_enabled = "true"
    volume_size = "25"
  }

  encrypt_at_rest = {
    enabled    = "false"
    kms_key_id = ""
  }

  log_publishing_options = {
    enabled                  = "true"
    log_type                 = "INDEX_SLOW_LOGS"
  }

  advanced_options = {
    "rest.action.multi.allow_explicit_index" = "true"
  }

  node_to_node_encryption_enabled                = "false"
  snapshot_options_automated_snapshot_start_hour = "23"

  tags = {
    Name            = "${var.project_name} ElasticSearch ${var.environment}"
    BU              = var.bu
    Project         = var.project_name
    Environment     = var.environment
    "Instance Name" = "${var.project_name} ElasticSearch ${var.environment}"
    "AWS Type"      = "ElasticSearch Instance"
  }
}
