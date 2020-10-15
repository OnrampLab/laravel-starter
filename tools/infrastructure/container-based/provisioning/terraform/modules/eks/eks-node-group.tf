resource "aws_eks_node_group" "eks-node-group" {
  cluster_name    = var.cluster-name
  node_group_name = "${var.cluster-name}-private-node-group"
  node_role_arn   = aws_iam_role.node.arn
  subnet_ids      = data.aws_subnet_ids.private.ids
  scaling_config {
    desired_size = var.desired-capacity
    max_size     = var.max-size
    min_size     = var.min-size
  }
  launch_template {
    id      = aws_launch_template.eks-node.id
    version = "$Latest"
  }

  # Ensure that IAM Role permissions are created before and deleted after EKS Node Group handling.
  # Otherwise, EKS will not be able to properly delete EC2 Instances and Elastic Network Interfaces.
  depends_on = [
    aws_eks_cluster.eks,
    aws_iam_role_policy_attachment.node-AmazonEKSWorkerNodePolicy,
    aws_iam_role_policy_attachment.node-AmazonEKS_CNI_Policy
  ]
}

resource "aws_launch_template" "eks-node" {
  instance_type = var.node-instance-type

  vpc_security_group_ids = [data.aws_security_group.node.id]

  tag_specifications {
    resource_type = "instance"

    tags = {
      Name            = "${var.cluster-name}-node"
      BU              = var.bu
      Project         = var.project_name
      Environment     = var.environment
      "Instance Name" = "${var.cluster-name}-node"
      "AWS Type"      = "EC2 Instance"
    }
  }
}
