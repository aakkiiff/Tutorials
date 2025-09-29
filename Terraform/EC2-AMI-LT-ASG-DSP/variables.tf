variable "region" {
  type = string
}

variable "services" {
  description = "List of services"
  type        = list(string)
}

variable "vpc_id" {
  type = string
}

variable "base_ami_id" {
  type = string
}

variable "instance_type" {
  type = string
}

variable "kaypair" {
  type = string
}

variable "subnet_id" {
  type = string
}

variable "volume_size" {
  type = number
}

variable "volume_type" {
  type = string
}

variable "asg_min_size" {
  type = number
}

variable "asg_max_size" {
  type = number
}

variable "asg_desired_capacity" {
  type = number
}

variable "instance_profile_name" {
  type = string
  
}