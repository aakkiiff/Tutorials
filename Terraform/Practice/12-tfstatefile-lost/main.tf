terraform {
  required_providers {
    aws = {
      source  = "hashicorp/aws"
      version = "~> 5.0"
    }
  }
}

provider "aws" {
  region = "ap-south-1"
}

############################
# INPUT VARIABLE
############################
variable "bucket_name" {
  description = "Name of the S3 bucket"
  type        = string
  default = "tst212"
}

############################
# S3 BUCKET
############################
resource "aws_s3_bucket" "website_bucket" {
  bucket = var.bucket_name

}

############################
# DISABLE BLOCK PUBLIC ACCESS
############################
resource "aws_s3_bucket_public_access_block" "public_access" {
  bucket = aws_s3_bucket.website_bucket.id

  block_public_acls       = false
  block_public_policy     = false
  ignore_public_acls      = false
  restrict_public_buckets = false
}

############################
# ENABLE WEBSITE HOSTING
############################
resource "aws_s3_bucket_website_configuration" "website_config" {
  bucket = aws_s3_bucket.website_bucket.id

  index_document {
    suffix = "index.html"
  }
}

############################
# BUCKET POLICY (PUBLIC READ)
############################
resource "aws_s3_bucket_policy" "public_policy" {
  bucket = aws_s3_bucket.website_bucket.id

  depends_on = [aws_s3_bucket_public_access_block.public_access]

  policy = jsonencode({
    Version = "2012-10-17"
    Statement = [
      {
        Sid       = "PublicReadGetObject"
        Effect    = "Allow"
        Principal = "*"
        Action    = "s3:GetObject"
        Resource  = "${aws_s3_bucket.website_bucket.arn}/*"
      }
    ]
  })
}

############################
# UPLOAD INDEX.HTML
############################
# resource "aws_s3_object" "index" {
#   bucket       = aws_s3_bucket.website_bucket.id
#   key          = "index.html"
#   content_type = "text/html"

#   source       = "./index.html"
# }
resource "aws_s3_object" "index" {
  bucket       = aws_s3_bucket.website_bucket.id
  key          = "index.html"
  content_type = "text/html"
  source       = "./index.html"

  etag = filemd5("./index.html")
}
############################
# OUTPUT WEBSITE URL
############################


output "website_url" {
  value = "http://${aws_s3_bucket.website_bucket.bucket}.s3-website.ap-south-1.amazonaws.com/"
}
