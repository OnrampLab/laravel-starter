output "rds_endpoint" {
  value = aws_db_instance.mysql_db_instance.*.endpoint
}

output "mysql_id" {
  value = aws_db_instance.mysql_db_instance.*.id
}

output "rds_master_password" {
  value = random_string.rds_master_password.result
}

output "rds_db_name" {
  value = aws_db_instance.mysql_db_instance.*.name
}

output "rds_db_username" {
  value = aws_db_instance.mysql_db_instance.*.username
}
