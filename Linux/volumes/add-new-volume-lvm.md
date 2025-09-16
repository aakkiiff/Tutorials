# Mounting a New Disk to /data With LVM
1. stop the vm in vmware
2. add new hardware > harddisk > scsi > create new virtual disk
3. turn on vm
4.  Verify New Disk

```
lsblk
```
Example output:
```
sda    8:0    0   40G  0 disk
└─sda1 8:1    0   40G  0 part /
sdb    8:16   0   20G  0 disk <<< should be added as sdx
```
5. Create a physical volume
```
sudo pvcreate /dev/sdb
```

6. Create a new volume group (or extend existing one with vgextend)
```
sudo vgcreate data-vg /dev/sdb
```
7. Create a logical volume (e.g., 20G)
```
sudo lvcreate -l 100%FREE -n data-lv data-vg
```
8. Format the logical volume
```
sudo mkfs.ext4 /dev/data-vg/data-lv
```
9. Mount it to /data
```
sudo mount /dev/data-vg/data-lv /data
```
10. Add to /etc/fstab for persistence
```
echo "/dev/data-vg/data-lv /data ext4 defaults 0 2" | sudo tee -a /etc/fstab
```
11. Verify
```
lsblk
```