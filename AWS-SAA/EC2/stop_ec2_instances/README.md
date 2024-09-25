# EC2 Instance Management

This Go application provides a simple command-line tool for managing Amazon EC2 instances across multiple regions. It lists all running instances and automatically terminates those that have been running for more than one hour. This tool is useful for managing long-running instances, ensuring that resources are optimized and costs are controlled.

  

## Features

  

- List running EC2 instances across all AWS regions.

- Automatically terminate instances that have been running for over one hour.

  
  

## Prerequisites

  

Before running the application, ensure you have the following:

  

1.  **AWS Account**: You need an AWS account with permissions to describe and terminate EC2 instances.

2.  **AWS CLI**: Install and configure the AWS Command Line Interface (CLI) with the necessary credentials. You can configure it using the following command:

```
aws configure
```

3. Go: Ensure you have Go installed on your machine.

## Installation Steps

1.  **Clone the Repository**: Clone the project repository to your local machine using the following command

```
git clone https://github.com/aakkiiff/Tutorials.git
cd ./AWS-SAA/EC2/stop_ec2_instances
```
2.  **Install Dependencies**: Install the necessary Go dependencies for the project by running:
```
go mod tidy
```
3.  **Build the Application**: Compile the Go application to create an executable:
```
go build
```
4.  **Run the Application**: Execute the application by running the compiled binary:
```
./stop_ec2_instances
```
## Usage

Upon execution, the application will:

- Check all AWS regions.

- List all running EC2 instances.

- Terminate any instance that has been running for more than one hour.
