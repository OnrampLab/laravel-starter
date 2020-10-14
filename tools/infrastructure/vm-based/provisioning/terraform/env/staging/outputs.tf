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
