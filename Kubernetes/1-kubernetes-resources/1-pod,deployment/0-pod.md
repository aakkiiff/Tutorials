
## What is Pod
In Kubernetes, a Pod is the smallest and simplest unit of deployment. It represents a single instance of a running process in your cluster. A Pod can contain one or more containers, which are tightly coupled and share resources such as networking and storage.

Create an NGINX Pod via imperative command\
`kubectl run nginx --image=nginx`

Create an NGINX Pod with manifest file\
`kubectl apply -f 0-pod.yaml`

Dry run. Print the corresponding API objects without creating them\
`kubectl run nginx --image=nginx --dry-run=client`

Generate POD Manifest YAML file (-o yaml) with (–dry-run)\
`kubectl run nginx --image=nginx --dry-run=client -o yaml`

Get the manifest file of a pod\
`kubectl get pod podname -o yaml`

Run with Labels, Example tier\
`kubectl run redis -l tier=db --image=redis:alpine`

Deploy a `redis` pod using the `redis:alpine` image with the labels set to `tier=db`.\
`kubectl run redis --image=redis:alpine --labels tier=db`

List all pods in all namespaces, with more details\
`kubectl get pods -o wide --all-namespaces`
`kubectl get pods -o wide -A`
