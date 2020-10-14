output "mysql_cluster_id" {
  value = module.rds.mysql_id
}

output "mysql_endpoint" {
  value = module.rds.rds_endpoint
}

output "mysql_master_password" {
  value     = module.rds.rds_master_password
  sensitive = true
}

output "mysql_master_username" {
  value = module.rds.rds_db_username
}

output "mysql_db_name" {
  value = module.rds.rds_db_name
}

output "vpc_id" {
  value = module.vpc.vpc_id
}

output "ec2_ip" {
  value = module.ec2.ec2_ip
}

output "ssh_key_path" {
  value = module.ec2.ssh_key_path
}

output "public_subnet_ids" {
  value = module.vpc.public_subnet_ids
}

output "private_subnet_ids" {
  value = module.vpc.private_subnet_ids
}
