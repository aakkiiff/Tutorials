# Demo values for the variables
variable "aws_region" {
  description = "your aws region"
  type        = string
  default     = "ap-south-1" # Mumbai region
}

variable "cluster_name" {
  description = "name of the cluster, will be the name of the VPC, should be unique"
  type        = string
  default     = "test-cluster" # Unique name for the VPC
}

variable "created_by" {
  description = "created by devops metadata"
  type        = string
  default     = "akif"
}

variable "vpc_cidr_block" {
  description = "cidr range of the VPC"
  type        = string
  default     = "10.0.0.0/16" # VPC CIDR block providing 65,536 IP addresses
}

variable "subnet_public-1_cidr" {
  description = "cidr range of the public subnet 1"
  type        = string
  default     = "10.0.1.0/24" # Public subnet 1 CIDR (256 IP addresses)
}

variable "subnet_public-2_cidr" {
  description = "cidr range of the public subnet 2"
  type        = string
  default     = "10.0.2.0/24" # Public subnet 2 CIDR (256 IP addresses)
}

variable "subnet_private-1_cidr" {
  description = "cidr range of the private subnet 1"
  type        = string
  default     = "10.0.3.0/24" # Private subnet 1 CIDR (256 IP addresses)
}

variable "subnet_private-2_cidr" {
  description = "cidr range of the private subnet 2"
  type        = string
  default     = "10.0.4.0/24" # Private subnet 2 CIDR (256 IP addresses)
}