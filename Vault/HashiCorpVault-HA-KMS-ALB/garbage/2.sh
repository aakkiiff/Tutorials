cat <<EOF > /etc/vault.d/vault.hcl
storage "raft" {
  path    = "/opt/vault"
  node_id = "vault-node-2"
}

listener "tcp" {
  address         = "0.0.0.0:8200"
  cluster_address = "0.0.0.0:8201"
  tls_disable     = 1
}

seal "awskms" {
  region     = "ap-south-1"
  kms_key_id = "d6913ebf-cbb3-4ceb-9ecd-113d8acced70"
}

# 👇 Set these to this node's actual IP!
cluster_addr = "http://172.31.14.76:8201"
api_addr     = "http://172.31.14.76:8200"

ui = true

EOF

vault operator init

vault operator raft list-peers

# export VAULT_TOKEN="zzzzzzzzzzzzzhl0wqd"


vault operator raft join http://172.31.9.92:8200
