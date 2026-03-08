# This is a basic Terraform configuration file (.tf) with variables

# 1. Define the provider
terraform {
  required_providers {
    local = {
      source  = "hashicorp/local"
      version = "~> 2.0"
    }
  }
}

# 2. Configure the provider
provider "local" {}

# 3. Define variables
variable "file_name" {
  description = "The name of the file to create"
  type        = string
  default     = "hello1.txt"
}

variable "file_content" {
  description = "Content to write inside the file"
  type        = string
  default     = "Hello, Terraform! 🚀"
}

# 4. Create a local file using variables
resource "local_file" "example" {
  filename = var.file_name
  content  = var.file_content
}

# 5. Output the filename
output "created_file" {
  value = var.file_name
}
