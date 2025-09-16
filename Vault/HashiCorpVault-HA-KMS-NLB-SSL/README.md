
# Vault Installation Guide (SSL Enabled)

![enter image description here](./assets/diagram.png)

## 🚀 Overview
This guide helps you deploy a **production-ready, highly available HashiCorp Vault cluster** on AWS using **3 EC2 instances**, with built-in **AWS KMS auto-unseal**, **Raft storage**, and **self-signed SSL encryption** for secure communication.

**Your Vault deployment will provide:**
-   🔄 **High Availability (HA):** Automatic leader election across multiple nodes for uninterrupted service
-   🔑 **Secure Key Management:** AWS KMS handles sealing and unsealing of Vault keys automatically.
-   🌐 **External Access:** Single, consistent endpoint through an **AWS Network Load Balancer (NLB)**.
-   🔐 **Encrypted Communication:** All traffic between Vault nodes and clients is secured with TLS.
    


----------

## 📋 Prerequisites

Before deploying your Vault cluster, ensure your environment meets the following requirements:

### 💻 EC2 Instances

You will need **3 EC2 instances** for a highly available setup:
-   `vault-1`
-   `vault-2`
-   `vault-3`
    
### 🖥️ System Requirements
-   **Memory:** Minimum **1 GB RAM** free per instance
-   **Ports:** `8200` (Vault API) and `8201` (Raft communication) must be open
-   **AMI:** Ubuntu Server **24.04 LTS (HVM)**
### 🛠️ Required Tools

| Tool          | Purpose                                                                |
| ------------- | ---------------------------------------------------------------------- |
| `wget`        | Download Vault packages and other files from the internet              |
| `gpg`         | Verify package signatures and repository keys                          |
| `lsb-release` | Detect your OS version for proper repository configuration             |
| `unzip`       | Extract zipped Vault binaries                                          |
| `curl`        | Test API endpoints and download additional resources                   |
| `zip`         | Create zipped archives if needed for backups or configuration packages |
| `openssl`     | To generate self-signed SSL/TLS certificates



## 🛠️ Steps
### 1. Create KMS Key For Vault Unsealing Process
-   **Key Type:** `Symmetric`
-   **Key Usage:** `Encrypt` and `Decrypt`
-   Attach the **default key policy** (or customize for your IAM users).
-   **Important:** Note down the **KMS Key ID**

 ### 2. Create IAM Policy & Role To Use This KMS Key

- Policy should be 
```
{
    "Version": "2012-10-17",
    "Statement": [
        {
            "Sid": "VaultKMSUnseal",
            "Effect": "Allow",
            "Action": [
                "kms:Encrypt",
                "kms:Decrypt",
                "kms:DescribeKey"
            ],
            "Resource": "arn:aws:kms:ap-south-1:137440810107:key/f7940434-6cdb-4f1c-b04a-7ad91c3cfac3"
        }
    ]
}
```
### 3. Create And Prepare EC2 Instances
Deploy **3 EC2 instances** for your Vault cluster:
| Node    | Private IP    |
| ------- | ------------- |
| Vault-1 | 172.31.7.142  |
| Vault-2 | 172.31.10.220 |
| Vault-3 | 172.31.12.216 |
- 💡 Tip: Ensure all instances are in the same VPC and subnet for smooth internal communication.
Configure security groups to allow Vault traffic:
	- Port 8200: Vault API
	- Port 8201: Raft cluster communication
- Assign **IAM roles** with KMS permissions to **all instances** for auto-unseal.

### 4. Create And Network Load Balancer
Set up an **NLB** to provide a single endpoint for your Vault cluster:

-  **Create a Target Group**
	-   **Target Type:** Instances
	-   **Protocol:** TCP
	-   **Port:** 8200 (Vault API)
	-   **Health Check:**
	    -   **Protocol:** HTTPS
	    -   **Path:** `/v1/sys/health`
-  **Create a Network Load Balancer**
	- Listeners
		- Protocol: TCP
		- Port: 8200

### 5. Create Route 53 Hosted Zone
- Type: Private hosted zone
- Add A Domain Name `test.intra`

- **Create Records**

| Hostname           | Type | Routing Policy | Alias | Value / IP Address                                                                   |
| ------------------ | ---- | -------------- | ----- | ------------------------------------------------------------------------------------ |
| vault.test.intra  | A    | Simple         | Yes   | vault-nlb-8629b8ffa112bb57.elb.ap-south-1.amazonaws.com (your Network Load Balancer) |
| vault1.test.intra | A    | Simple         | No    | 172.31.7.142 (private IP of Vault-1 EC2 instance)                                    |
| vault2.test.intra | A    | Simple         | No    | 172.31.10.220 (private IP of Vault-2 EC2 instance)                                   |
| vault3.test.intra | A    | Simple         | No    | 172.31.12.216 (private IP of Vault-3 EC2 instance)                                   |


### 6. Prepare EC2 Instances & Install Vault (On Each node)
#### **Switch to root on each node**

```sudo su```

#### **Set the hostname for each Vault node**

| Node    | Command                                |
| ------- | -------------------------------------- |
| Vault-1 | `sudo hostnamectl set-hostname vault1` |
| Vault-2 | `sudo hostnamectl set-hostname vault2` |
| Vault-3 | `sudo hostnamectl set-hostname vault3` |

> 🖊️ Tip: Use consistent hostnames to match your DNS records (vault1.test.intra, etc.).

#### **Update `/etc/hosts` for fallback resolution**

- On each Vault node, Run

```
echo "127.0.0.1 $(hostname).test.intra $(hostname)" | sudo tee -a /etc/hosts
```

#### Verify Hostname Resolution Across Nodes
eg. On `Vault-1` node
```
nslookup vault3.test.intra
Server:		127.0.0.53
Address:	127.0.0.53#53

Non-authoritative answer:
Name:	vault3.test.intra
Address: 172.31.12.216 <Vault 3 EC2 Private IP Should Resolve>
```
```
nslookup vault2.test.intra
...
...
Address: 172.31.10.220 <Vault 3 EC2 Private IP Should Resolve>
```
```
root@vault1:/home/ubuntu# nslookup vault1.test.intra
Server:		127.0.0.53
Address:	127.0.0.53#53

vault1.test.intra	canonical name = localhost.
Name:	localhost
Address: 127.0.0.1

```

#### Install Vault On Each node
```
sudo apt update
sudo apt install -y wget gpg lsb-release unzip curl zip openssl

wget -O- https://apt.releases.hashicorp.com/gpg | sudo gpg --dearmor -o /usr/share/keyrings/hashicorp-archive-keyring.gpg
echo "deb [arch=$(dpkg --print-architecture) signed-by=/usr/share/keyrings/hashicorp-archive-keyring.gpg] https://apt.releases.hashicorp.com $(lsb_release -cs) main" | sudo tee /etc/apt/sources.list.d/hashicorp.list

sudo apt update
```

**List and install required vault version **
- On each Vault node
```
apt list -a vault

sudo apt install vault -y
vault version
```
#### 🗄️ Prepare Raft Storage Directory
- On each Vault node, create a dedicated directory for Raft storage:
```
sudo mkdir -p /data/raft
sudo chown -R vault:vault /data
sudo chmod -R 750 /data
```
#### 🔐 Generate Self-Signed SSL Certificate (Vault 1 Node Only)
- Only On **Vault 1 Node** , run the following command to create a **private key** and **self-signed certificate**:
```
openssl req -x509 -nodes -days 3650 -newkey rsa:4096 -keyout vault.key -out vault.crt \
-subj "/CN=vault.test.intra" \
-addext "subjectAltName = DNS:vault.test.intra, DNS:vault1.test.intra, DNS:vault2.test.intra, DNS:vault3.test.intra"
```
#### Zip The Certs & Send Them To Other Nodes
```
zip vault-tls.zip vault.crt vault.key
```
- Transfer vault-tls.zip file to the 2nd and 3rd nodes also run the below command.
```
unzip vault-tls.zip
```

#### Move Cert Files To Appropriate Directory On Each node

Place TLS Certificate in config dir for all nodes
```
sudo mkdir -p /etc/vault.d/tls
sudo mv vault.crt vault.key /etc/vault.d/tls/
sudo chown -R vault:vault /etc/vault.d/tls
sudo chmod 600 /etc/vault.d/tls/vault.key
sudo chmod 644 /etc/vault.d/tls/vault.crt
```

Copy the certificate to the CA directory
```
sudo cp /etc/vault.d/tls/vault.crt /usr/local/share/ca-certificates/vault.crt
```

Update the system's CA certificates
```
sudo update-ca-certificates
```
> This certificate is the self-signed TLS certificate for the Vault cluster (`vault.test.intra`, `vault1.test.intra`, `vault2.test.intra`, `vault3.test.intra`).  
It is placed in the system’s trusted CA directory so Ubuntu will trust Vault’s HTTPS connections.  
Since it is self-signed, there is no external Certificate Authority; the certificate itself acts as its own CA.
#### ⚙️ Configure Vault on Each Instance

🗄️ Node-Specific Configuration
On Vault 1 (`vault1.test.intra`)
Edit Configuration
```
vim /etc/vault.d/vault.hcl
```
```
storage "raft" {
  path    = "/data/raft"
  node_id = "vault1"

  retry_join {
    leader_api_addr         = "https://vault1.test.intra:8200"
    leader_ca_cert_file     = "/etc/vault.d/tls/vault.crt"
  }
  retry_join {
    leader_api_addr         = "https://vault2.test.intra:8200"
    leader_ca_cert_file     = "/etc/vault.d/tls/vault.crt"
  }
  retry_join {
    leader_api_addr         = "https://vault3.test.intra:8200"
    leader_ca_cert_file     = "/etc/vault.d/tls/vault.crt"
  }
}

listener "tcp" {
  address         = "0.0.0.0:8200"
  cluster_address = "0.0.0.0:8201"
  tls_cert_file   = "/etc/vault.d/tls/vault.crt"
  tls_key_file    = "/etc/vault.d/tls/vault.key"
}

api_addr      = "https://vault.test.intra:8200"
cluster_addr  = "https://vault1.test.intra:8201"
disable_mlock = true
ui            = true
```
---
On Vault 2 (`vault2.test.intra`)
Edit Configuration
```
vim /etc/vault.d/vault.hcl
```
```
storage "raft" {
  path    = "/data/raft"
  node_id = "vault2"

  retry_join {
    leader_api_addr         = "https://vault1.test.intra:8200"
    leader_ca_cert_file     = "/etc/vault.d/tls/vault.crt"
  }
  retry_join {
    leader_api_addr         = "https://vault2.test.intra:8200"
    leader_ca_cert_file     = "/etc/vault.d/tls/vault.crt"
  }
  retry_join {
    leader_api_addr         = "https://vault3.test.intra:8200"
    leader_ca_cert_file     = "/etc/vault.d/tls/vault.crt"
  }
}

listener "tcp" {
  address         = "0.0.0.0:8200"
  cluster_address = "0.0.0.0:8201"
  tls_cert_file   = "/etc/vault.d/tls/vault.crt"
  tls_key_file    = "/etc/vault.d/tls/vault.key"
}

api_addr      = "https://vault.test.intra:8200"
cluster_addr  = "https://vault2.test.intra:8201"
disable_mlock = true
ui            = true
```
---
On Vault 3 (`vault3.test.intra`)
Edit Configuration
```
vim /etc/vault.d/vault.hcl
```
```
storage "raft" {
  path    = "/data/raft"
  node_id = "vault3"

  retry_join {
    leader_api_addr         = "https://vault1.test.intra:8200"
    leader_ca_cert_file     = "/etc/vault.d/tls/vault.crt"
  }
  retry_join {
    leader_api_addr         = "https://vault2.test.intra:8200"
    leader_ca_cert_file     = "/etc/vault.d/tls/vault.crt"
  }
  retry_join {
    leader_api_addr         = "https://vault3.test.intra:8200"
    leader_ca_cert_file     = "/etc/vault.d/tls/vault.crt"
  }
}

listener "tcp" {
  address         = "0.0.0.0:8200"
  cluster_address = "0.0.0.0:8201"
  tls_cert_file   = "/etc/vault.d/tls/vault.crt"
  tls_key_file    = "/etc/vault.d/tls/vault.key"
}

api_addr      = "https://vault.test.intra:8200"
cluster_addr  = "https://vault3.test.intra:8201"
disable_mlock = true
ui            = true
```

#### Enable and start vault On Each node

```
sudo systemctl enable vault && sudo systemctl start vault
sudo systemctl status vault
```
#### Initialize the Cluster (Vault 1 node)
- On  **Vault 1 node**

```
export VAULT_ADDR="https://vault1.test.intra:8200"
export VAULT_SKIP_VERIFY=true
vault operator init
```
**Sample Output:**
```
Unseal Key 1: 1TRu6BKuiqVf2OOdLxLcS8Cm9J3hrLDxriB70LJH6lbJ
Unseal Key 2: KEF0Gz/Z7w2vw2yq22UhsSwDHx+zj5JLKwWloWPSKbMY
Unseal Key 3: MKnPhn1pztOlPB7wq56Aqmlj90nTCSOGenWeO8Bybh5A
Unseal Key 4: JAJPhxrNt/MGQaAWowDOMLzIDWvUnqaq94mgeTX4FZtU
Unseal Key 5: liQFWQWAlIqmNVjibnJxaiJ3jOEzfc2G0z01vu1QcGKu

Initial Root Token: hvs.QdeSZyUHTgD4jnlKEJrhYLjj
```
> Note Down The Keys For Future References

- Verify
On Each Node 
```
vault status
```
Shoud Output
```
Key                      Value
---                      -----
Seal Type                awskms
Recovery Seal Type       shamir
Initialized              true
Sealed                   false <----(False means KMS unsealing is properly working)
Total Recovery Shares    5
Threshold                3
Version                  1.20.2
Build Date               2025-08-05T19:05:39Z
Storage Type             raft
Cluster Name             vault-cluster-233e0c51
Cluster ID               c1c8e92b-0c9c-a65f-4413-c0547222c3f0
Removed From Cluster     false
HA Enabled               true
HA Cluster               https://vault1.test.intra:8201
HA Mode                  active
Active Since             2025-08-13T10:27:30.813261355Z
Raft Committed Index     110
Raft Applied Index       110

```
Check The Raft Members:
```
vault login hvs.QdeSZyUHTgD4jnlKEJrhYLjj
watch vault operator raft list-peers
```
Output
```
Node      Address                    State       Voter
----      -------                    -----       -----
vault1    vault1.test.intra:8201    leader      true
vault2    vault2.test.intra:8201    follower    true
vault3    vault3.test.intra:8201    follower    true
```

## 🛠️ Troubleshooting
#### If vault2 and vault3 members do not join the raft
- On Vault 2 node
```
export VAULT_ADDR="https://vault2.test.intra:8200"
export VAULT_SKIP_VERIFY=true
vault operator raft join https://vault1.test.intra:8200
```
 - On Vault 3 node
```
export VAULT_ADDR="https://vault3.test.intra:8200"
export VAULT_SKIP_VERIFY=true
vault operator raft join https://vault1.test.intra:8200
```
#### If needed we can also restart & check logs

🔄 Restart Vault Service
```
sudo systemctl restart vault
```
📜 View Vault Logs in Real-Time
```
journalctl -xeu vault -f
```
## 🗳️ Raft Quorum & Leader Checks
🔍 Check Raft Cluster Status
```
vault operator raft list-peers
```
**Example Output:**
```
Node      Address                    State       Voter
----      -------                    -----       -----
vault1    vault1.test.intra:8201    follower    true
vault2    vault2.test.intra:8201    leader      true
vault3    vault3.test.intra:8201    follower    true
```
🔄 Force a Leader Change
```
vault operator step-down
```
Output(Changed Leader)
```
Node      Address                    State       Voter
----      -------                    -----       -----
vault1    vault1.test.intra:8201    leader      true
vault2    vault2.test.intra:8201    follower    true
vault3    vault3.test.intra:8201    follower    true
```

## 🔨 Resetting a Vault Node’s Raft Storage (Destructive Action)
Execute On A Node
```
sudo systemctl stop vault
rm -rf /data/raft
rm -rf /opt/vault/data/
sleep 1
sudo mkdir -p /data/raft
sudo chown -R vault:vault /data
sudo chmod -R 750 /data
sudo systemctl start vault
```
This will
-  Remove all Vault data
- Restart it
- Since the hcl file contains the vault address, it will join the cluster automatically

## **Vault Audit Logging Setup Guide**
Audit logs help track all requests and responses to your Vault cluster, which is critical for security, compliance, and troubleshooting.
### **1. Create Log Directory**
Vault needs a directory to store audit files. Run the following commands: (Execute On All Node)
```
sudo mkdir -p /var/log/vault
sudo chown vault:vault /var/log/vault
sudo chmod 750 /var/log/vault
``` 	

### 2. Enable File-Based Audit Logging Or Enable Service-Based Audit Logging (Syslog)
**File-based audit logs are stored locally on the Vault node.**(Any Node)
```
vault audit enable file file_path=/var/log/vault/audit.log
```
**Notes:**
-   Logs will be written to `/var/log/vault/audit.log`.
**Syslog-based audit logs integrate with the system logging service**(Any Node)

### Or,

```
vault audit enable syslog tag="vault" facility=local0
```
**Notes:**

-   Logs are sent to the system’s syslog (`journald`).
-   `tag="vault"` helps identify Vault logs in syslog.
-   `facility=local0` allows using a dedicated syslog facility for Vault.

#### Verify
```
vault audit list
```
```
Path       Type      Description
----       ----      -----------
file/      file      n/a
syslog/    syslog    n/a
```

check logs - on master node
```
journalctl -xeu vault -f
```
