# VMWARE download
1. https://blogs.vmware.com/workstation/2024/05/vmware-workstation-pro-now-available-free-for-personal-use.html
2. sign up
3. download vmware pro for personal use
4. make it executable
5. execute it
6. run vmware (might face gcc compiler version 12 not available)
7. install

## VMware Workstation GCC Compiler Error
```bash
sudo apt update
sudo apt-get install build-essential linux-headers-generic
sudo apt install build-essential
```
If does not work, try second steps.

```
sudo add-apt-repository ppa:ubuntu-toolchain-r/ppa -y
sudo apt update
sudo apt install g++-12 gcc-12
```

## VMware several modules must be compiled and loaded into the running kernel Error!!!**

```bash
git clone https://github.com/mkubecek/vmware-host-modules.git 
cd vmware-host-modules/ 
git branch -r 
git checkout workstation-16.2.5 
make 
sudo make install 
sudo /etc/init.d/vmware start
```

