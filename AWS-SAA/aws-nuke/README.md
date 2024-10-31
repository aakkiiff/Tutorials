# aws-nuke
## Overview
Helps you to Remove all resources from an AWS account.
## Ref
main repo: https://github.com/ekristen/aws-nuke/blob/main/README.md
docs: https://github.com/ekristen/aws-nuke/tree/main/docs
## Get started
- create an aws account
- run `aws configue` on your machine to authenticate with the account
- add an account alias [ here](https://us-east-1.console.aws.amazon.com/iam/home#/home)
- **edit nuke-config.yaml file** 
- add the regions you want your resources to be nuked
```
regions:
	- global
	- us-east-1
	- us-east-2
	- us-west-1
	....
	...
```
- list the accounts you want to block,never to be nuked(safety precautions)
```
blocklist:
	- "999999999999"  # production account
```

- account to be nuked
```
accounts:
	"51xxx53yy064": {}
```
- resources to be nuked
```

resource-types:
	
	includes:
			# S3
			- S3Object
			- S3Bucket
			# EC2 + EBS/EFS + Load Balancer + ASG
			- EC2Instance
			- EC2NATGateway
			- EC2SpotFleetRequest
			- EC2Volume
			- EC2KeyPair
		  - EFSFileSystem
			- EFSMountTarget  
			- ELB
			- ELBv2
			- ELBv2ListenerRule
			- ELBv2TargetGroup	  
			- AutoScalingGroup
			- AutoScalingLaunchConfiguration
			- AutoScalingLifecycleHook
			- AutoScalingPlansScalingPlan
			# Elastic Beanstalk
			- ElasticBeanstalkApplication
			- ElasticBeanstalkEnvironment
			# EKS + ECS
			- EKSCluster
			- EKSFargateProfile
			- EKSNodegroup
			- ECSCapacityProvider
			- ECSCluster
			- ECSClusterInstance
			- ECSService
			- ECSTask
			- ECSTaskDefinition
	
```

- resources to be excluded
```
excludes:
	- IAMAccountSettingPasswordPolicy
	- IAMGroup
	- IAMGroupPolicy
	- IAMGroupPolicyAttachment
	- IAMInstanceProfile
	- IAMInstanceProfileRole
	- IAMLoginProfile
	- IAMOpenIDConnectProvider
```
- to list the available resources
`aws-nuke resource-types`

- command to nuke
`aws-nuke run --config nuke-config.yaml --no-dry-run`
