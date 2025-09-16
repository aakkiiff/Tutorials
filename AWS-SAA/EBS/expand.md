# expand ebs volume
## option 1
1. turn off ec2. 
2. expand. 
3. turn on ec2. 

## option 2
1. expand ebs 8 -> 12gb
2. shell to ec2
```
root@ip-172-31-5-118:/home/ubuntu# df -h
Filesystem       Size  Used Avail Use% Mounted on
/dev/root        6.8G  1.8G  5.0G  27% /
tmpfs            458M     0  458M   0% /dev/shm
tmpfs            183M  900K  182M   1% /run
tmpfs            5.0M     0  5.0M   0% /run/lock
efivarfs         128K  4.1K  119K   4% /sys/firmware/efi/efivars
```
still it is 8 gb

```
root@ip-172-31-5-118:/home/ubuntu# lsblk
NAME         MAJ:MIN RM  SIZE RO TYPE MOUNTPOINTS
loop0          7:0    0 27.2M  1 loop /snap/amazon-ssm-agent/11320
loop1          7:1    0 73.9M  1 loop /snap/core22/1981
loop2          7:2    0 50.9M  1 loop /snap/snapd/24505
nvme0n1      259:0    0   *12G*  0 disk <<<----this 
├─nvme0n1p1  259:2    0    7G  0 part /
├─nvme0n1p14 259:3    0    4M  0 part 
├─nvme0n1p15 259:4    0  106M  0 part /boot/efi
└─nvme0n1p16 259:5    0  913M  0 part /boot

```
```
sudo growpart /dev/nvme0n1 1
sudo resize2fs /dev/nvme0n1p1

```
now it should be

```
root@ip-172-31-5-118:/home/ubuntu# df -h
Filesystem       Size  Used Avail Use% Mounted on
/dev/root         11G  1.8G  8.9G  17% /   <<----
tmpfs            458M     0  458M   0% /dev/shm
tmpfs            183M  900K  182M   1% /run
tmpfs            5.0M     0  5.0M   0% /run/lock
efivarfs         128K  4.1K  119K   4% /sys/firmware/efi/efivars
/dev/nvme0n1p16  881M   86M  734M  11% /boot
/dev/nvme1n1      20G   24K   19G   1% /mnt/ebs_volume
/dev/nvme0n1p15  105M  6.2M   99M   6% /boot/efi
tmpfs             92M   12K   92M   1% /run/user/1000
root@ip-172-31-5-118:/home/ubuntu# lsblk
NAME         MAJ:MIN RM  SIZE RO TYPE MOUNTPOINTS
loop0          7:0    0 27.2M  1 loop /snap/amazon-ssm-agent/11320
loop1          7:1    0 73.9M  1 loop /snap/core22/1981
loop2          7:2    0 50.9M  1 loop /snap/snapd/24505
nvme0n1      259:0    0   12G  0 disk  <<<<----
├─nvme0n1p1  259:2    0   11G  0 part /  <<<----
├─nvme0n1p14 259:3    0    4M  0 part 
├─nvme0n1p15 259:4    0  106M  0 part /boot/efi
└─nvme0n1p16 259:5    0  913M  0 part /boot
nvme1n1      259:1    0   20G  0 disk /mnt/ebs_volume
root@ip-172-31-5-118:/home/ubuntu# 

```
