**if we dont want to change our router ip block to 172.17.17.1 series**

**by default we will have 192.168.0.1 series ip block in our router.**
# in that case
### you use these ip's, like....
- master node static ip: 192.168.0.250
- worker node static ip: 192.168.0.251
##### or any ip you desire, that do not overlap with other devices ip

### then you must update your kubeadm init command ,apiserver-advertise-address and pod-network-cidr
example kubeadm init command
```
sudo kubeadm init \
  --apiserver-advertise-address=192.168.0.250 \
  --pod-network-cidr=172.16.0.0/16 \
  --cri-socket /run/containerd/containerd.sock \
  --ignore-preflight-errors=Swap
```
#### notice that we changed the pod network cidr, this is because we dont want out pods ip to overlap with nodes ip.

### then you must match 172.16.0.0/16 this range in calico configuration.
> look for step 6 in the documentation

>6. Install Calico networking for on-premises deployments (Master Node)

>https://github.com/aakkiiff/Tutorials/tree/main/Kubernetes/0-Cluster_setup/1-kubernetes-setup#6-install-calico-networking-for-on-premises-deployments-master-node

- after executing this step a file will be downloaded
`curl https://raw.githubusercontent.com/projectcalico/calico/v3.29.0/manifests/custom-resources.yaml -O`

then you must edit this file and change the cidr part
```
# This section includes base Calico installation configuration.
# For more information, see: https://docs.tigera.io/calico/latest/reference/installation/api#operator.tigera.io/v1.Installation
apiVersion: operator.tigera.io/v1
kind: Installation
metadata:
  name: default
spec:
  # Configures Calico networking.
  calicoNetwork:
    ipPools:
    - name: default-ipv4-ippool
      blockSize: 26
      
      ### this part <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
      cidr: 172.16.0.0/16  
      
      encapsulation: VXLANCrossSubnet
      natOutgoing: Enabled
      nodeSelector: all()
---
# This section configures the Calico API server.
# For more information, see: https://docs.tigera.io/calico/latest/reference/installation/api#operator.tigera.io/v1.APIServer
apiVersion: operator.tigera.io/v1
kind: APIServer
metadata:
  name: default
spec: {}
```
next steps will be the same.

