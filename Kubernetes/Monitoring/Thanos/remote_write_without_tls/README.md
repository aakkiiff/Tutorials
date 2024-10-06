we are going to setup structure1
# Structure 1


![diagram](https://github.com/aakkiiff/Kubernetes/blob/main/Monitoring/Thanos/remote_write_without_tls/assets/MONITOR.jpg?raw=true)

## Cluster Setup

- 2 Kubernetes cluster is needed
- "**thanos cluster**" : contains all the thanos components and grafana

- goal of this cluster is to have all the monitoring aggregation components and visualize with grafana


- "**monitored cluster**" : contains the prometheus component and minio 

- goal of this cluster is to have prometheus component which sends metric to the receiver in the thanos cluster(remote write)
and host a aws s3/object storage compatible storage solution == minio  

- Kubeadm/any kubernetes environment

- current cluster version 1.28

- **configure storage class for data persistence**


	- for kubeadm cluster setup we can use nfs subdirectory external provisioner


	- [https://github.com/kubernetes-sigs/nfs-subdir-external-provisioner/tree/master/charts/nfs-subdir-external-provisioner](https://github.com/kubernetes-sigs/nfs-subdir-external-provisioner/tree/master/charts/nfs-subdir-external-provisioner)


	- here we have installed the storageclass with the name "nfs-client"



## Object storage setup


object storage can be aws s3 or local/remote minio instance. here we will setup a minio instance on cluster "monitored-cluster"


**steps on monitored cluster**

this step is normally ignored if you are using AWS S3,

as we do not have S3 configured we will install minio, object storage solution,which we will deploy on our local kubernetes cluster.


- create minio ns


`kubectl apply -f monitored-cluster/0.ns`


- create all the objects in the minio directory


`kubectl apply -f monitored-cluster/1.minio/`


- minio console is exposed as loadbalancer, brows it(see 1.minio/console-service.yaml)


- username: admin, password:devops123

- create a bucket 'test'

- create access key and secret access keys


- note down the keys,bucket name, loadbalancer ip of minio(not console service) (we will use this data to populate the file **2.object-secret/ in both cluster configuration thanos and monitored cluster**)


*minio part is done here*



## Thanos setup


**steps on thanos cluster**


- first we need a monitoring namespace


`kubectl apply -f thanos-cluster/0.ns`


- now we need to apply the object storage configuration ,that we got from minio

`kubectl apply -f thanos-cluster/2.object-secret`


- create receiver-1, receiver-2
```
$k apply -f thanos-cluster/3.receiver-1/
service/receiver-store-1 created
statefulset.apps/receiver-1 created

$k apply -f thanos-cluster/4.receiver-2/
service/receiver-store-2 created
statefulset.apps/receiver-2 created
```


- apply hashring


`k apply -f thanos-cluster/5.hashring/`


- apply receiver-write-service


`kubectl apply -f thanos-cluster/6.receiver-write-svc`


- apply the thanos directory


	- querier

	- storagegateway

	- compactor

`kubectl apply -f thanos-cluster/7.thanos`


```
$ k apply -f thanos-cluster/7.thanos/

serviceaccount/thanos created
deployment.apps/querier created
service/querier created
statefulset.apps/storegateway created
service/storegateway created
persistentvolumeclaim/compactor created
deployment.apps/compactor created
```


## Prometheus setup


**steps on monitored cluster**


- create object-storage secret


`k apply -f monitored-cluster/2.object-secret/`


- get the receiver-write loadbalancer public ip from thanos cluster and update the prometheus file in the monitored cluster(file:// monitored-cluster/5.prometheus/3-prometheus.yaml)

```
remoteWrite:

- url: http://172.17.18.104:10908/api/v1/receive

queueConfig:

maxSamplesPerSend: 1000

maxShards: 200

capacity: 2500

```


- create prometheus crd at monitored cluster


`k create -f monitored-cluster/3.prometheus-operator-crds`


- apply operator rbac and deployment directory

`k apply -f monitored-cluster/4.prometheus-operator/deployment`

`k apply -f monitored-cluster/4.prometheus-operator/rbac`


- now apply the whole Prometheus directory

`k apply -f monitored-cluster/5.prometheus/`


-  **apply the nodeexporter**

`k apply -f monitored-cluster/nodeexporter/`


this will send node metrics to the prometheus server

then prometheus will send metrics to the thanos cluster receiver

then querier will get the metrics from the receiver and we can integrate grafana with querier and have a central dashboard!


## Confirmation



- now check prometheus logs that it is able to send logs to the receiver

- check logs of premetheus,compactor,storage gateway,querier

- confirm from prometheus ui/querier ui; you will be able to see cpu_utilization metrics

# grafana

- deploy the grafana on the thanos cluster

`kubectl apply -f thanos-cluster/8.grafana/`

- after deployment add querier service as the datasource

`querier:9090`

- create dashboards

## Sources

**Prometheus manifests available at** - [here](https://github.com/prometheus-operator/kube-prometheus/tree/main/manifests)


**prometheus docker images available at** - [here](https://quay.io/repository/prometheus/prometheus?tab=tags)


**prometheus operator available at** - [here](https://github.com/prometheus-operator/prometheus-operator)


**thanos github** - [here](https://github.com/bitnami/charts/tree/main/bitnami/thanos)


**thanos docker hub by bitnami** - [here](https://hub.docker.com/r/bitnami/thanos/tags)


## references

1. https://medium.com/nerd-for-tech/deep-dive-into-thanos-part-ii-8f48b8bba132

2. https://tanzu.vmware.com/developer/guides/prometheus-multicluster-monitoring/

3. https://youtu.be/feHSU0BMcco?si=E-4AGraiZUH3OQED

4. https://youtu.be/qTxunwzYO0g?si=jjIQAeQ0Iivz36qR

5. https://github.com/prometheus-operator/prometheus-operator/blob/main/Documentation/additional-scrape-config.md

6. https://www.youtube.com/watch?v=mtE4migphGE

7. https://devopscube.com/node-exporter-kubernetes/

8. https://github.com/techiescamp/kubernetes-prometheus/blob/master/prometheus-ingress.yaml

9. https://www.opsramp.com/guides/prometheus-monitoring/prometheus-node-exporter/