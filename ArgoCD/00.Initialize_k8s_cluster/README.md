1. install awscli
> msiexec.exe /i https://awscli.amazonaws.com/AWSCLIV2.msi
https://docs.aws.amazon.com/cli/latest/userguide/getting-started-install.html

2. Install EKSCTL 
> choco install eksctl
https://eksctl.io/installation/

3. configure aws
> aws configure

4. initialize cluster
> eksctl create cluster -f cluster.yaml