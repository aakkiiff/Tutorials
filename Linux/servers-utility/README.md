- Step 1: Install fzf
> sudo apt update && sudo apt install fzf
- Step 2: Create or Update ~/.ssh/config
```
Host qaquickops
    HostName 128.xx.187.xx
    User xx
    Port xx

Host prodserver
    HostName 192.168.1.xx
    User xx
    Port xx

```
- Step 3: Create the Utility Script
> chmod +x servers

- Step 5: Add the Script to Your PATH
> sudo mv ssh-select /usr/local/bin/

- Step 6: Run the Utility