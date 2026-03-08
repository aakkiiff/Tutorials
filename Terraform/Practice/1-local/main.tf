# This is a basic Terraform configuration file (.tf)

# 1. Define the provider (here we use the "local" provider)
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

# 3. Create a local file (example resource)
resource "local_file" "example" {
  filename = "hello.txt"
  content  = "Hello, Terraform! 🚀"
}

