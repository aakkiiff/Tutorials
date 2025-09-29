locals {
  services = var.services
}

# Security Groups for all services using a loop
resource "aws_security_group" "service_sg" {
  for_each = toset(local.services)

  name        = "${each.value}-SG"
  description = "Security group for ${each.value}"
  vpc_id      = var.vpc_id
  # Inbound rule: Allow SSH from specified security group
  ingress {
    description = "SSH from specified SG"
    from_port   = 22
    to_port     = 22
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  # Outbound rule: Allow all traffic
  egress {
    description = "Allow all outbound traffic"
    from_port   = 0
    to_port     = 0
    protocol    = "-1" # -1 means all protocols
    cidr_blocks = ["0.0.0.0/0"]
  }

  tags = {
    Name = "${each.value}-SG"
  }
}
