# if you can not reset your cluster as some of the cni pods fails to be deleted, follow the following steps.
# unoptimized version
# sudo crictl config --set runtime-endpoint=unix:///run/containerd/containerd.sock

`sudo kubeadm reset -f`
`sudo rm -rf /etc/kubernetes/`
`sudo rm -rf ~/.kube/`
`sudo rm -rf /var/lib/etcd /var/lib/kubelet /var/lib/cni /var/run/kubernetes`
# Remove CNI Plugins
`sudo rm -rf /etc/cni/net.d`
`sudo rm -rf /opt/cni/bin`
# Restart the Network Interface (if needed)
`sudo systemctl restart networking`
# List and Remove All Pods and Containers with `crictl`
`# List all pods`
`sudo crictl pods`
# List all containers
`sudo crictl ps -a`
# Remove all containers
`sudo crictl rm $(sudo crictl ps -a -q)`
# Remove all pods
`sudo crictl rmp $(sudo crictl pods -q)`
# Clean Up Container Runtime Directories
If pods and containers still persist, clean up the container runtime’s data directories, especially for CRI-O, containerd, or Docker. Delete files specific to your runtime:
For **containerd**:
```
sudo systemctl stop containerd
sudo rm -rf /var/lib/containerd
sudo systemctl start containerd
```
For **CRI-O**:
```
sudo systemctl stop crio
sudo rm -rf /var/lib/containers/
sudo systemctl start crio
```
For **Docker**:
```
sudo systemctl stop docker
sudo rm -rf /var/lib/docker
sudo systemctl start docker
```
# Restart the Container Runtime
`sudo systemctl restart containerd # or crio, or docker, depending on your runtime`
