# Create AMIs for each EC2 instance
resource "aws_ami_from_instance" "service_ami" {
  for_each = toset(local.services)

  name                    = "ami-${each.value}-${formatdate("YYYY-MM-DD", timestamp())}"
  source_instance_id      = aws_instance.service_instance[each.value].id
  snapshot_without_reboot = true

  tags = {
    Name       = "ami-${each.value}"
    Created_by = "Terraform"

  }

  depends_on = [aws_instance.service_instance]
}