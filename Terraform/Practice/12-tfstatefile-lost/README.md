# Recover Terraform State (Lost `tfstate` File)

If you lose your Terraform `tfstate` file, you can recover the state by re-importing the existing infrastructure into Terraform.

---

## Step 1: Initialize Terraform

Run the following command to initialize Terraform:

```bash
terraform init
```
## Step 2: Import Existing Resources

Import each resource individually using your bucket name (tst212).
```
terraform import aws_s3_bucket.website_bucket tst212

terraform import aws_s3_bucket_public_access_block.public_access tst212

terraform import aws_s3_bucket_website_configuration.website_config tst212

terraform import aws_s3_bucket_policy.public_policy tst212

terraform import aws_s3_object.index tst212/index.html
```
## Step 3: Verify the State

After importing all resources, run:

```bash
terraform plan
```

### Expected Result:
Ideally, Terraform should show no changes, indicating that the state file now matches the existing infrastructure.