output "vpc_id" {
  description = "name of the VPC"
  value       = aws_vpc.devops_vpc.id
}

output "subnet_id_private_1" {
  value = aws_subnet.devops_subnet_private_1.id
}

output "subnet_id_private_2" {
  value = aws_subnet.devops_subnet_private_2.id
}

output "subnet_id_public_1" {
  value = aws_subnet.devops_subnet_public_1.id
}

output "subnet_id_public_2" {
  value = aws_subnet.devops_subnet_public_2.id
}