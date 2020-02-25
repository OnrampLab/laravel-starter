locals {
  use_eip = length(lookup(var.public_ips, terraform.workspace, "")) > 0
}

data "aws_eip" "ec2_ip" {
  count     = local.use_eip == true ? 1 : 0
  public_ip = lookup(var.public_ips, terraform.workspace)
}

data "aws_region" "current" {}

data "aws_ami" "ubuntu" {
  most_recent = true

  filter {
    name   = "name"
    values = ["ubuntu/images/hvm-ssd/ubuntu-bionic-18.04-amd64-server-*"]
  }

  filter {
    name   = "virtualization-type"
    values = ["hvm"]
  }

  owners = ["099720109477"] # Canonical
}

# ALB

resource "aws_security_group" "lb_sg" {
  description = "controls access to the application ELB"

  vpc_id = var.vpc_id
  name   = "${var.stack_name}-lbsg"

  ingress {
    protocol    = "tcp"
    from_port   = 80
    to_port     = 80
    cidr_blocks = ["0.0.0.0/0"]
  }

  egress {
    from_port = 0
    to_port   = 0
    protocol  = "-1"

    cidr_blocks = [
      "0.0.0.0/0",
    ]
  }
}

resource "aws_alb_target_group" "alb_tg" {
  name     = "${var.stack_name}-tg"
  port     = 80
  protocol = "HTTP"
  vpc_id   = var.vpc_id
}

resource "aws_alb" "alb" {
  name            = "${var.stack_name}-alb"
  subnets         = var.subnet_ids
  security_groups = [aws_security_group.lb_sg.id]
}

resource "aws_alb_listener" "web" {
  load_balancer_arn = aws_alb.alb.id
  port              = "80"
  protocol          = "HTTP"

  default_action {
    target_group_arn = aws_alb_target_group.alb_tg.id
    type             = "forward"
  }
}

resource "aws_lb_target_group_attachment" "svc_physical_external" {
  target_group_arn = aws_alb_target_group.alb_tg.arn
  target_id        = aws_instance.vm.id
  port             = 80
}

# EC2

resource "aws_eip_association" "proxy_eip" {
  count         = local.use_eip == true ? 1 : 0
  instance_id   = aws_instance.vm.id
  allocation_id = data.aws_eip.ec2_ip[count.index].id
}

resource "aws_instance" "vm" {
  ami                         = data.aws_ami.ubuntu.id
  instance_type               = "t2.small"
  associate_public_ip_address = true
  key_name                    = aws_key_pair.generated.key_name
  vpc_security_group_ids      = [aws_security_group.ec2_security_group.id]
  subnet_id                   = var.subnet_ids[0]
  iam_instance_profile        = aws_iam_instance_profile.vm_profile.name

  tags = {
    Name            = "${var.project_name} ${var.environment}"
    BU              = var.bu
    Project         = var.project_name
    Environment     = var.environment
    "Instance Name" = "${var.project_name} ${var.environment}"
    "AWS Type"      = "EC2 Instance"
  }
}

resource "aws_security_group" "ec2_security_group" {
  name   = "${var.stack_name}-ec2"
  vpc_id = var.vpc_id

  ingress {
    protocol    = "tcp"
    from_port   = 22
    to_port     = 22
    cidr_blocks = ["0.0.0.0/0"]
  }

  ingress {
    protocol    = "tcp"
    from_port   = 80
    to_port     = 80
    cidr_blocks = ["0.0.0.0/0"]
  }

  ingress {
    protocol    = "tcp"
    from_port   = 443
    to_port     = 443
    cidr_blocks = ["0.0.0.0/0"]
  }

  egress {
    protocol    = -1
    from_port   = 0
    to_port     = 0
    cidr_blocks = ["0.0.0.0/0"]
  }

  tags = {
    Name        = "${var.project_name} EC2 ASG ${var.environment}"
    BU          = var.bu
    Project     = var.project_name
    Environment = var.environment
    "AWS Type"  = "Security Group"
  }
}

resource "aws_iam_instance_profile" "vm_profile" {
  name = "vm_profile_${var.stack_name}_${terraform.workspace}"
  role = aws_iam_role.role.name
}

resource "aws_iam_role" "role" {
  name = "ec2_role_${var.stack_name}_${terraform.workspace}"
  path = "/"

  assume_role_policy = <<EOF
{
    "Version": "2012-10-17",
    "Statement": [
        {
            "Action": "sts:AssumeRole",
            "Principal": {
               "Service": "ec2.amazonaws.com"
            },
            "Effect": "Allow",
            "Sid": ""
        }
    ]
}
EOF
}

resource "aws_iam_role_policy" "ec2_role_policy" {
  name = "ec2-policy-${var.stack_name}"
  role = aws_iam_role.role.id

  policy = <<EOF
{
  "Version": "2012-10-17",
  "Statement": [
      {
         "Effect": "Allow",
         "Action": [
            "logs:*"
         ],
         "Resource": [
            "*"
         ]
      }
  ]
}
EOF
}

locals {
  public_key_filename  = "./key-${terraform.workspace}.pub"
  private_key_filename = "./key-${terraform.workspace}"
}

resource "tls_private_key" "default" {
  algorithm = "RSA"
}

resource "aws_key_pair" "generated" {
  depends_on = [tls_private_key.default]
  key_name   = "key-${var.stack_name}-${terraform.workspace}"
  public_key = tls_private_key.default.public_key_openssh
}

resource "local_file" "public_key_openssh" {
  depends_on = [tls_private_key.default]
  content    = tls_private_key.default.public_key_openssh
  filename   = local.public_key_filename
}

resource "local_file" "private_key_pem" {
  depends_on = [tls_private_key.default]
  content    = tls_private_key.default.private_key_pem
  filename   = local.private_key_filename
}

resource "null_resource" "chmod" {
  depends_on = [local_file.private_key_pem]

  provisioner "local-exec" {
    command = "chmod 400 ${local.private_key_filename}"
  }
}

resource "null_resource" "install_python_for_vm" {
  depends_on = [aws_instance.vm, local_file.private_key_pem]

  connection {
    host        = aws_instance.vm.public_ip
    type        = "ssh"
    user        = "ubuntu"
    private_key = file(local.private_key_filename)
  }

  # Instance need python to run ansible commands
  provisioner "remote-exec" {
    inline = ["sudo apt-get -qq install python -y"]
  }
}

resource "null_resource" "ansible" {
  depends_on = [aws_instance.vm, local_file.private_key_pem]

  provisioner "local-exec" {
    command = <<EOT
      >hosts.ini;
      echo "[hosts]" | tee -a hosts.ini;
      echo "${aws_instance.vm.public_ip} ansible_user=ubuntu ansible_ssh_private_key_file=${local.private_key_filename}" | tee -a hosts.ini;
      ansible-playbook -i hosts.ini ../../../ansible/provision-${lower(var.environment)}.yml
    EOT

    environment = {
      ANSIBLE_HOST_KEY_CHECKING = "False"
      ANSIBLE_CONFIG            = "../../../ansible/ansible.cfg"
    }
  }
}
