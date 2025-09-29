# Create Launch Templates for each AMI
resource "aws_launch_template" "service_launch_template" {
  for_each = toset(local.services)

  name        = "LT-${each.value}"
  description = "Launch template for ${each.value} using AMI"

  image_id      = aws_ami_from_instance.service_ami[each.value].id
  instance_type = var.instance_type
  key_name      = var.kaypair

  # Network interfaces with security group
  network_interfaces {
    associate_public_ip_address = true # Enable public IP (adjust as needed)
    subnet_id                   = var.subnet_id
    security_groups             = [aws_security_group.service_sg[each.value].id]
  }

  # IAM instance profile
  iam_instance_profile {
    name = var.instance_profile_name
  }

  # Storage: gp3 30GB
  block_device_mappings {
    device_name = "/dev/xvda"
    ebs {
      volume_type = var.volume_type
      volume_size = var.volume_size
    }
  }

  # Enable detailed CloudWatch monitoring
  monitoring {
    enabled = true
  }

  # Instance metadata options
  metadata_options {
    http_endpoint               = "enabled"
    http_tokens                 = "required"
    http_put_response_hop_limit = 2
  }
  disable_api_termination = false

  tags = {
    Name       = "LT-${each.value}"
    Created_by = "Terraform"

  }
  tag_specifications {
    resource_type = "instance"
    tags = {
      Name    = "LT-${each.value}"
      Version = aws_ami_from_instance.service_ami[each.value].id
    }
  }
  update_default_version = true
  depends_on             = [aws_ami_from_instance.service_ami]
}

# Create Auto Scaling Group for each service
resource "aws_autoscaling_group" "service_asg" {
  for_each = toset(local.services)

  name                = "ASG-${each.value}"
  desired_capacity    = var.asg_desired_capacity
  min_size            = var.asg_min_size
  max_size            = var.asg_max_size
  vpc_zone_identifier = [var.subnet_id]

  launch_template {
    id = aws_launch_template.service_launch_template[each.value].id
    # version = "$Latest"
    version = aws_launch_template.service_launch_template[each.value].latest_version

  }

  health_check_type         = "EC2"
  health_check_grace_period = 0

  instance_refresh {
    strategy = "Rolling"
    preferences {
      min_healthy_percentage = 0 # Lowered to allow refresh with single instance
      skip_matching          = true
      instance_warmup        = 300 # Adjusted to align with health check grace period
    }
    triggers = ["launch_template"]
  }

  tag {

    key                 = "Name"
    value               = "ASG-${each.value}"
    propagate_at_launch = true

  }

  depends_on = [aws_launch_template.service_launch_template]
}
