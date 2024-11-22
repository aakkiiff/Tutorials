
## Creating a Deployment
To create a Deployment imperatively (using imperative commands) for nginx.\
`kubectl create deployment nginx-deployment --image=nginx:1.14.2 --replicas=3`

Optionally, you can generate the Deployment manifest.\
`kubectl run deployment nginx-deployment --image=nginx:1.14.2 --replicas=3 --dry-run=client -o yaml`

## generate deployment manifest
`kubectl run deployment nginx-deployment --image=nginx:1.14.2 --replicas=3 --dry-run=client -o yaml > file.yaml`

## Updating nginx-deployment deployment
Let's update the nginx Pods to use the nginx:1.16.1 image instead of the nginx:1.14.2 image.\
`kubectl set image deployment/nginx-deployment nginx=nginx:1.16.1`

Alternatively, you can edit the Deployment and change.\
`kubectl edit deployment/nginx-deployment`


## Scaling a Deployment
You can scale a Deployment by using the following command.
`kubectl scale deployment/nginx-deployment --replicas=10`

## List all deployment, with more details\
`kubectl get deployment -o wide`


## delete deployment
`kubectl delete deployments test`