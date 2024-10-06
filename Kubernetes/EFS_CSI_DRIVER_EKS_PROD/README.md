# **Integrating AWS EKS With AWS  EKS Using EFS CSI Driver** [ recommended for production]


## What is AWS EKS?

Amazon Elastic Kubernetes Service, is a managed Kubernetes service provided by Amazon Web Services (AWS). It simplifies the process of deploying, managing, and scaling containerized applications using Kubernetes. EKS takes care of the underlying infrastructure, such as server provisioning and cluster management, allowing DevOps engineers like yourself to focus on deploying and managing containerized applications.

  

## What is AWS EFS?

Amazon Elastic File System, is a scalable and managed file storage service provided by Amazon Web Services (AWS). It's designed to provide scalable, shared storage for Amazon EC2 instances and containerized applications. EFS makes it easier for DevOps engineers like you to create and manage file systems that can be accessed concurrently by multiple instances, making it well-suited for applications that require shared file storage in a cloud environment.

  

## Why we need to integrate Manually AWS EFS with AWS EKS?

Well, connecting to AWS EFS is not a out of the box support aws eks provides,you have to do some manual tasks to deploy efs driver.Which are described in the following points. we can either use helm chart/addon option for efs which we will discuss below.

  

## Prerquisite:(have these installed)

1.  aws cli installed.
2.  CLI configured in your local machine to use your aws account with appropriate permissions ( you can use admin privileges for testing perposes)
3.  kubectl installed
4. eksctl installed
5. helm installed

  

## STEPS:

 1. Create a AWS EKS cluster:

    eksctl create cluster -f cluster.yml
wait for the cluster to be up and running. This might take 10-15 minutes

 2. Now create a AWS EFS file system from console.
-  navigate to aws efs in the console
- select create file system
- select the vpc your eks cluster running on*
- give it a name(optional)
- and create!
3. now efs is created in different az depending on the region you are deploying the efs.we have to configure so that our kubernetes deployments can access them.
- go to the ec2 dashboard
- select one of our nodes and go to security section
- there is a cluster wide sg for our nodes,like this `[sg-091f8dd1d912164dd (eksctl-akif-cluster-ClusterSharedNodeSecurityGroup-S2529JYD8EFP)]`
- copy the sg and navigate to the efs you created
- go to network section and click on manage
- cross out the existing security groups and populate with the one you copied and save 
4.  Creating an IAM OIDC provider for your cluster

    eksctl utils associate-iam-oidc-provider --cluster $cluster_name --approve
    
   5.Create an IAM policy and role for Amazon EKS ([reference](https://github.com/kubernetes-sigs/aws-efs-csi-driver/blob/master/docs/iam-policy-create.md))
 -  Create an IAM policy that allows the CSI driver's service account to make calls to AWS APIs on your behalf.

 - [ ] Download the IAM policy document.

     `curl -O https://raw.githubusercontent.com/kubernetes-sigs/aws-efs-csi-driver/master/docs/iam-policy-example.json`

 - [ ] Create the policy. You can change `EKS_EFS_CSI_Driver_Policy` to a different name, but if you do, make sure to change it in later steps too.

    `aws iam create-policy --policy-name EKS_EFS_CSI_Driver_Policy --policy-document file://iam-policy-example.json`

 - [ ] Run the following command to create the IAM role and Kubernetes service account. It also attaches the policy to the role, annotates the Kubernetes service account with the IAM role ARN, and adds the Kubernetes service account name to the trust policy for the IAM role. Replace `my-cluster` with your cluster name and `111122223333` with your account ID. Replace `region-code` with the AWS Region that your cluster is in.
 

    `eksctl create iamserviceaccount --cluster my-cluster --namespace kube-system --name efs-csi-controller-sa --attach-policy-arn arn:aws:iam::111122223333:policy/EKS_EFS_CSI_Driver_Policy --approve --region region-code`

 - [ ] check if the iamservice account created or not,
 

    `kubectl get sa -n kube-system | grep efs-csi-controller-sa`

5.lets deploy the csi driver.execute following commands and add the service account name if you changed it:
- `helm repo add aws-efs-csi-driver https://kubernetes-sigs.github.io/aws-efs-csi-driver/`
- `helm repo update aws-efs-csi-driver`
- `helm upgrade --install aws-efs-csi-driver --namespace kube-system aws-efs-csi-driver/aws-efs-csi-driver --set controller.serviceAccount.create=false --set controller.serviceAccount.name=efs-csi-controller-sa `
- check if they are running well with this command`kubectl get po -n kube-system`


5. now lets deploy the storage class,pvc and pod
- make sure to add your filesystem id to the sc.yml file
- `kubectl apply -f sc.yml`
- `kubectl apply -f pod.yml`
6. now check the pvc,it should be in bound state and the pod should be running!  

