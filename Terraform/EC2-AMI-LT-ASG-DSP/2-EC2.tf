
# EC2 Instances for all services using a loop
resource "aws_instance" "service_instance" {
  for_each = toset(local.services)

  ami           = var.base_ami_id
  instance_type = var.instance_type
  key_name      = var.kaypair

  # Associate with the corresponding security group
  vpc_security_group_ids = [aws_security_group.service_sg[each.value].id]

  subnet_id = var.subnet_id

  # IAM instance profile
  # iam_instance_profile = "FoodiEC2Role" # Name of the role, not the full ARN

  # Storage: gp3 30GB
  root_block_device {
    volume_type = var.volume_type
    volume_size = var.volume_size
  }

  # User data script to update packages and create deployment.sh
  user_data = <<EOF
#!/bin/bash
sudo apt update -y
sudo apt upgrade -y

# Create /opt directory if it doesn't exist
sudo mkdir -p /opt

# Create deployment.sh with service-specific values
cat << 'SCRIPT' > /opt/deployment.sh
#!/bin/bash

container_name="${each.value}-service"

http_port="6040"

ecr_url="439282343946.dkr.ecr.ap-southeast-1.amazonaws.com/${each.value}"

aws ecr get-login-password --region ap-southeast-1 | docker login --username AWS --password-stdin 439282343946.dkr.ecr.ap-southeast-1.amazonaws.com

echo "Enter Docker image tag:"

read tag

# Define the new image name
new_image_name="$ecr_url:$tag"
# Stop the running container
docker stop "$container_name"
# Remove everything of Docker
docker system prune -a -f
# Pull the Docker image
if docker pull "$new_image_name"; then
  docker rm -f "$container_name" >/dev/null 2>&1
  # Run the container
  docker run -e TZ=Asia/Dhaka -d -p "$http_port":"$http_port" --name "$container_name" --restart always "$new_image_name"
else
  echo "Build failed. The previous container will continue running."
fi
SCRIPT

# Set executable permissions for deployment.sh
sudo chmod +x /opt/deployment.sh
EOF

  # Enable termination protection
  disable_api_termination = false

  # Enable detailed CloudWatch monitoring
  monitoring = true

  # Instance metadata options
  metadata_options {
    http_endpoint               = "enabled"
    http_tokens                 = "required"
    http_put_response_hop_limit = 2
  }

  tags = {
    Name       = "${each.value}"
    Created_by = "Terraform"
  }

  depends_on = [aws_security_group.service_sg]
}