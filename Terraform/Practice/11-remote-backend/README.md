# you lost your tfstate file
- terraform init

Step 2: Import resources one by one

Use your bucket name (tst212):

terraform import aws_s3_bucket.website_bucket tst212

terraform import aws_s3_bucket_public_access_block.public_access tst212

terraform import aws_s3_bucket_website_configuration.website_config tst212

terraform import aws_s3_bucket_policy.public_policy tst212

terraform import aws_s3_object.index tst212/index.html


Step 3: Verify
terraform plan

👉 Ideally: No changes


-----------------------------------

