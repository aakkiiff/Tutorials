
#VPC
resource "aws_vpc" "devops_vpc" {
  cidr_block       = var.vpc_cidr_block
  instance_tenancy = "default"
  tags = {
    Name       = var.cluster_name
    created_by = var.created_by
  }
}

# IGW
resource "aws_internet_gateway" "devops_igw" {
  vpc_id = aws_vpc.devops_vpc.id
  tags = {
    Name       = format("%s igw", var.cluster_name)
    created_by = var.created_by
  }
  depends_on = [aws_vpc.devops_vpc]
}

# public subnet 1

resource "aws_subnet" "devops_subnet_public_1" {
  vpc_id                  = aws_vpc.devops_vpc.id
  cidr_block              = var.subnet_public-1_cidr
  map_public_ip_on_launch = true
  availability_zone       = "${var.aws_region}a"
  tags = {
    Name       = format("%s public-1", var.cluster_name)
    created_by = var.created_by
  }
  depends_on = [aws_vpc.devops_vpc]
}

# public subnet 2

resource "aws_subnet" "devops_subnet_public_2" {
  vpc_id                  = aws_vpc.devops_vpc.id
  cidr_block              = var.subnet_public-2_cidr
  map_public_ip_on_launch = true
  availability_zone       = "${var.aws_region}b"
  tags = {
    Name       = format("%s public-2", var.cluster_name)
    created_by = var.created_by
  }
  depends_on = [aws_vpc.devops_vpc]
}

#private subnet 1
resource "aws_subnet" "devops_subnet_private_1" {
  vpc_id            = aws_vpc.devops_vpc.id
  cidr_block        = var.subnet_private-1_cidr
  availability_zone = "${var.aws_region}a"
  tags = {
    Name       = format("%s private_1", var.cluster_name)
    created_by = var.created_by

  }
  depends_on = [aws_vpc.devops_vpc]
}

#private subnet 2
resource "aws_subnet" "devops_subnet_private_2" {
  vpc_id            = aws_vpc.devops_vpc.id
  cidr_block        = var.subnet_private-2_cidr
  availability_zone = "${var.aws_region}b"
  tags = {
    Name       = format("%s private_2", var.cluster_name)
    created_by = var.created_by

  }
  depends_on = [aws_vpc.devops_vpc]
}


# eip
resource "aws_eip" "devops_nat_eip" {
  domain     = "vpc"
  depends_on = [aws_internet_gateway.devops_igw]
  tags = {
    Name       = format("%s nat_eip", var.cluster_name)
    created_by = var.created_by
  }
}

# nat
resource "aws_nat_gateway" "devops_nat" {
  allocation_id = aws_eip.devops_nat_eip.id
  subnet_id     = aws_subnet.devops_subnet_public_1.id

  tags = {
    Name       = format("%s nat", var.cluster_name)
    created_by = var.created_by
  }
  depends_on = [aws_internet_gateway.devops_igw, aws_eip.devops_nat_eip]
}

#Public RT
resource "aws_route_table" "devops_subnet_public_rt" {
  vpc_id = aws_vpc.devops_vpc.id

  route {
    cidr_block = var.vpc_cidr_block
    gateway_id = "local"
  }
  route {
    cidr_block = "0.0.0.0/0"
    gateway_id = aws_internet_gateway.devops_igw.id
  }

  tags = {
    Name       = format("%s public_rt", var.cluster_name)
    created_by = var.created_by
  }
  depends_on = [aws_internet_gateway.devops_igw]
}

#Private RT
resource "aws_route_table" "devops_subnet_private_rt" {
  vpc_id = aws_vpc.devops_vpc.id

  route {
    cidr_block = var.vpc_cidr_block
    gateway_id = "local"
  }
  route {
    cidr_block = "0.0.0.0/0"
    gateway_id = aws_nat_gateway.devops_nat.id
  }

  tags = {
    Name       = format("%s private_rt", var.cluster_name)
    created_by = var.created_by
  }
  depends_on = [aws_internet_gateway.devops_igw, aws_nat_gateway.devops_nat]
}

#RT Association Public
resource "aws_route_table_association" "devops_subnet_public_rt_association1" {
  subnet_id      = aws_subnet.devops_subnet_public_1.id
  route_table_id = aws_route_table.devops_subnet_public_rt.id
  depends_on     = [aws_route_table.devops_subnet_public_rt, aws_subnet.devops_subnet_public_1]
}

resource "aws_route_table_association" "devops_subnet_public_rt_association2" {
  subnet_id      = aws_subnet.devops_subnet_public_2.id
  route_table_id = aws_route_table.devops_subnet_public_rt.id
  depends_on     = [aws_route_table.devops_subnet_public_rt, aws_subnet.devops_subnet_public_2]
}

#RT Association Private
resource "aws_route_table_association" "devops_subnet_private_rt_association1" {
  subnet_id      = aws_subnet.devops_subnet_private_1.id
  route_table_id = aws_route_table.devops_subnet_private_rt.id
  depends_on     = [aws_route_table.devops_subnet_private_rt, aws_subnet.devops_subnet_private_1]
}

resource "aws_route_table_association" "devops_subnet_private_rt_association2" {
  subnet_id      = aws_subnet.devops_subnet_private_2.id
  route_table_id = aws_route_table.devops_subnet_private_rt.id

  depends_on = [aws_route_table.devops_subnet_private_rt, aws_subnet.devops_subnet_private_2]
}
