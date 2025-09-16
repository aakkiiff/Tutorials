# Extending / With LVM
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

6. Extend  volume group
```
sudo  vgextend  ubuntu-vg  /dev/sdb
```
7.  Extend logical volume
```
lvextend -l +100%FREE /dev/ubuntu-vg/ubuntu-lv
```
8. Resize file system
```
resize2fs /dev/ubuntu-vg/ubuntu-lv
```