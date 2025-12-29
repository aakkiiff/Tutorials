
## Prerequisites for Installing a Kubernetes Cluster
To install Kubernetes Cluster on your Ubuntu machine, make sure it meets the following requirements:
- At list 1 Node (dev) 
- 2 vCPUs
- At least 4GB of RAM
- At least 20 GB of Disk Space
- A reliable internet connection

## Overall configurations steps
1. Setting up the Static IPV4 on all nodes.
2. Disabling swap & Setting up hostnames.
3. Installing Kubernetes components on all nodes.
4. Initializing the Kubernetes cluster.
5. Configuring Kubectl.
6. Configure Calico Network operator.
7. Print Join token & add worker nodes in the cluster.
8. Deploy Applications.


## 1. Setting up Static IPV4 on all nodes (Master & Worker Node).
Configure Static IP Address on Ubuntu 22.04 (Master & Worker Node)\
first check the dhcp ip and interface `ip a`.\
Edit netplan file add and update IP Address as your Network.

```bash
network:
  version: 2
  renderer: networkd
  ethernets:
    ens33:
      dhcp4: no
      addresses:
        - 192.168.10.245/24
      routes:
        - to: default
          via: 192.168.10.1
      nameservers:
          addresses: [8.8.8.8, 8.8.4.4]
```
Apply changes.\
`sudo netplan apply`


## 2. Disabling swap & Setting up hostnames (Master & Worker Node).
(might not need to disable swap for upcoming versions)\

```bash
sudo apt-get update
sudo swapoff -a
sudo vim /etc/fstab
sudo init 6
```
Setup hostname all nodes (Masternode should be master & worker node should be worker).\
`sudo hostnamectl set-hostname "master-node"`

## 3. Installing Kubernetes components on all nodes (Master & Worker Node).

### 3.1 Configure modules (Master & Worker Node).
Configure modules required by containerd (Master & Worker Node).\
Description: Configure kernel modules necessary for containerd to operate seamlessly.

```bash
cat <<EOF | sudo tee /etc/modules-load.d/k8s.conf
overlay
br_netfilter
EOF
```
```bash
sudo modprobe br_netfilter
sudo modprobe overlay
```
### 3.2 Configure Networking (Master & Worker Node).
Configure system parameters for networking and CRI (Master & Worker Node).\
Description: Set up system parameters related to networking for Kubernetes and the Container Runtime Interface (CRI).

```bash
cat <<EOF | sudo tee /etc/sysctl.d/k8s.conf
net.bridge.bridge-nf-call-iptables  = 1
net.bridge.bridge-nf-call-ip6tables = 1
net.ipv4.ip_forward                 = 1
EOF
```

```
sudo sysctl --system
```

### 3.3 Install containerd (Master & Worker Node).
Description: Install the container runtime (containerd) for managing containers.
```bash
sudo apt-get update
sudo apt-get install -y containerd
```
### 3.4 Modify containerd configuration (Master & Worker Node).
Description: Configure containerd to enable systemd cgroup integration.
```bash
sudo mkdir -p /etc/containerd
sudo containerd config default | sudo tee /etc/containerd/config.toml
sudo sed -i 's/SystemdCgroup \= false/SystemdCgroup \= true/g' /etc/containerd/config.toml
cat /etc/containerd/config.toml
```
`sudo systemctl restart containerd.service`

`sudo systemctl status containerd`

### 3.5 Install Kubernetes Management Tools (Master & Worker Node).
Description: Install using native package management, Install essential Kubernetes management tools - Kubeadm, Kubelet, and Kubectl.

[Reference](https://kubernetes.io/docs/tasks/tools/install-kubectl-linux/#install-using-native-package-management)
```bash
sudo apt-get update
# apt-transport-https may be a dummy package; if so, you can skip that package
sudo apt-get install -y apt-transport-https ca-certificates curl gnupg


# If the folder `/etc/apt/keyrings` does not exist, it should be created before the curl command, read the note below.
# sudo mkdir -p -m 755 /etc/apt/keyrings
curl -fsSL https://pkgs.k8s.io/core:/stable:/v1.31/deb/Release.key | sudo gpg --dearmor -o /etc/apt/keyrings/kubernetes-apt-keyring.gpg
sudo chmod 644 /etc/apt/keyrings/kubernetes-apt-keyring.gpg # allow unprivileged APT programs to read this keyring

# This overwrites any existing configuration in /etc/apt/sources.list.d/kubernetes.list
echo 'deb [signed-by=/etc/apt/keyrings/kubernetes-apt-keyring.gpg] https://pkgs.k8s.io/core:/stable:/v1.31/deb/ /' | sudo tee /etc/apt/sources.list.d/kubernetes.list
sudo chmod 644 /etc/apt/sources.list.d/kubernetes.list   # helps tools such as command-not-found to work correctly

```
```bash
sudo apt-get update
sudo apt-get install -y kubelet kubeadm kubectl
sudo apt-mark hold kubelet kubeadm kubectl
```


## 4. Initialization the Kubernetes Cluster (Master Node).
Description: Initialize the Kubernetes control-plane on the master server.

`sudo kubeadm init --apiserver-advertise-address=172.17.17.200 --pod-network-cidr=192.168.0.0/16 --cri-socket /run/containerd/containerd.sock --ignore-preflight-errors Swap`

- 172.17.17.200 this is your k8s Master Server IP
- 192.168.0.0/16 this is Pod CIDR if you change this you have to udpate CNI Network Configuration operator file also.

## issue!
Depending on the os version, you might see this error
```
[ERROR FileExisting-conntrack]: conntrack not found in system path
```
Solution:
```
sudo apt install -y conntrack
```

## 5. Configuring Kubectl (Master Node).
Description: This step focuses on creating the kubeconfig file, a crucial configuration file for using the `kubectl` command on the master node. Create kubeconfig file to use kubectl command 

```bash
mkdir -p $HOME/.kube
sudo cp -i /etc/kubernetes/admin.conf $HOME/.kube/config
sudo chown $(id -u):$(id -g) $HOME/.kube/config
```



## 6. Install Calico networking for on-premises deployments (Master Node)
[Reference](https://projectcalico.docs.tigera.io/getting-started/kubernetes/self-managed-onprem/onpremises).\
Description: In this step, we'll install Calico, a powerful networking solution, to facilitate on-premises deployments in your Kubernetes cluster.

Install the operator on your cluster.\
`kubectl create -f https://raw.githubusercontent.com/projectcalico/calico/v3.29.0/manifests/tigera-operator.yaml`

Download the custom resources necessary to configure Calico.\
`curl https://raw.githubusercontent.com/projectcalico/calico/v3.29.0/manifests/custom-resources.yaml -O`

If you wish to customize the Calico install, customize the downloaded custom-resources.yaml manifest locally and Create the manifest in order to install Calico.
`kubectl create -f custom-resources.yaml`

## 7. Print Join token for worker Node to join Cluster (Master Node).
Description: Print the join command Master Server and use it to add nodes to the Kubernetes cluster.

`kubeadm token create --print-join-command`

### 7.1 Join worker Node to the Cluster (Worker Node)
Description: Join Node to the Cluster (Node Configuration)

`execute output of kubeadm token create --print-join-command on worker nodes`


### 7.2 Get Cluster Info (Master Node)
Get APi resources list and sort name\
`kubectl api-resources `

Display addresses of the master and services\
`kubectl cluster-info`

Dump current cluster state to stdout\
`kubectl cluster-info dump`

## 8. Deploy Applications into k8s Cluster (Master Node)
To deploy Nginx using the imperative approach in Kubernetes.\
`kubectl create deployment nginx-deployment --image=nginx --replicas=3 --port=80`

If you want to expose the Nginx deployment externally, you can create a service.\
`kubectl expose deployment nginx-deployment --type=LoadBalancer --name=nginx-service`

And you can also check the running pods and Services.

```bash
kubectl get pods
kubectl get services
```

---

# Common scenarios
sometimes we set a static ip address but upon vm restart the fixed ip is resetted to the old ip. which leads to ip address blunder

## 🛠️ Disabling `cloud-init` Networking for Static IP Configuration

The `50-cloud-init.yaml` file is autogenerated by `cloud-init` in Ubuntu cloud-based VMs and sets network interfaces via DHCP.

### Why It Matters

When setting up static IPs (e.g., for Kubernetes), this file can:
- Override manual Netplan configs
- Reset interfaces on reboot
- Cause conflicts in multi-node environments

### How to Disable It

1. **Disable cloud-init:**
   ```bash
   sudo touch /etc/cloud/cloud-init.disabled
    ```
2. update the file to set your static ip:

refer: step 1. Setting up Static IPV4 on all nodes (Master & Worker Node).

`sudo vim /etc/netplan/50-cloud-init.yaml`

---
