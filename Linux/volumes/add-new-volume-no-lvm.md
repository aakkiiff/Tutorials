# Mounting a New Disk to /data Without LVM
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
5. Create Partition on /dev/sdb
```
sudo fdisk /dev/sdb
```
- n new partition
- everythong else should be default
- w write



6. 🧱 Format the Partition
```
sudo mkfs.ext4 /dev/sdb1
```
7. 📂 Create the Mount Directory
```
sudo mkdir -p /data
```
8. 🖇️ Mount the Disk Temporarily
```
sudo mount /dev/sdb1 /data
```
To verify:
```
df -h | grep /data
```
9. 🛡️ Mount Disk Permanently (Edit /etc/fstab)
Instead of using UUID, you can directly use /dev/sdb1 if you're sure the device name won't change.

Edit /etc/fstab:
```
sudo nano /etc/fstab
```
Add this line at the bottom:
```
/dev/sdb1  /data  ext4  defaults  0  2
```
Save and exit.

