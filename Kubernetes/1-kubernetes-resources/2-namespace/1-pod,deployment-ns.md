# create deployment in test namespace
`kubectl create deployment deploymentname -n test --image nginx`

# get deployment in test namespace
`kubectl get deployment -n test`

# get deployment in all namespace
`kubectl get deployment -A`

## List all deployment in all namespaces, with more details\

`kubectl get deployment -o wide -A`

## List all pods in all namespaces, with more details\

`kubectl get pods -o wide -A`