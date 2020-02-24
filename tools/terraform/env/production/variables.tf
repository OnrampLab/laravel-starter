variable "environment" {
  type = string
}

variable "stack_name" {
  type = string
}

variable "bu" {
  type = string
}

variable "project_name" {
  type = string
}

variable "aws_region" {
  type = string
}

variable "aws_profile" {
  type = string
}

variable "vpc_cidr" {
  type = string
}

variable "public_ips" {
  type = map
}
