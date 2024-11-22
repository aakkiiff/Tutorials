## get namespaces
`kubectl get namespaces`

## create namespace
`kubectl create namespace ns-name`

## get ns manifest file
`k get namespace default -oyaml`

## generate manifest file
`k create namespace test -o yaml --dry-run=client > filename.yaml`

## create
`kubectl apply -f filename.yaml`

