resource "aws_instance" "my_ec2" {
  ami           = "ami-019715e0d74f695be"
  instance_type = "t2.micro"

  subnet_id     = module.VPC.subnet_id_public_1


  tags = {
    Name = "${var.cluster_name}-jenkins"
  }
  
}

# userdata to install jenkins on ec2 instance