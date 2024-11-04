# Setup Dynamic NFS Provisioning in Kubernetes Cluster
=======================================================

**Step1: Prepare the NFS Server** \
First lets install NFS server on the host machine
```
sudo apt update
sudo apt install nfs-kernel-server -y
```
Create a directory where our NFS server will serve the files.
```
sudo mkdir -p /var/k8-nfs/data
sudo chown -R nobody:nogroup /var/k8-nfs/data
sudo chmod 2770 /var/k8-nfs/data
```

Add NFS export options
```
sudo vi /etc/exports	
/var/k8-nfs/data 172.17.17.0/24(rw,sync,no_subtree_check,no_root_squash,no_all_squash)
```

Makes the specified directories available for NFS clients to access and restart the NFS Service
```
sudo exportfs -avr
sudo systemctl restart nfs-kernel-server
sudo systemctl status nfs-kernel-server
```

On the worker and master nodes, install nfs-common package using following
`sudo apt install nfs-common -y`

**Step 2: Install and Configure NFS Client Provisioner**\
[NFS subdir external provisioner References](https://github.com/kubernetes-sigs/nfs-subdir-external-provisioner)
```
helm repo add nfs-subdir-external-provisioner https://kubernetes-sigs.github.io/nfs-subdir-external-provisioner
helm install nfs-subdir-external-provisioner nfs-subdir-external-provisioner/nfs-subdir-external-provisioner --set nfs.server=172.17.17.74 --set nfs.path=/var/k8-nfs/data
```

**Step 3: Create Persistent Volume Claims (PVCs)**\
`vi demo-pvc.yml`
```
kind: PersistentVolumeClaim
apiVersion: v1
metadata:
  name: test-claim
spec:
  storageClassName: nfs-client
  accessModes:
    - ReadWriteMany
  resources:
    requests:
      storage: 10Mi
```
Apply PVC

`kubectl create -f demo-pvc.yml` \
`kubectl get pv,pvc`
