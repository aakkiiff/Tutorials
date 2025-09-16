// node 1

cat << EOF > /etc/vault.d/vault.hcl
storage "raft" {
  path    = "/opt/vault"
  node_id = "vault-node-1"

  retry_join {
    leader_api_addr = "http://172.31.14.77:8200"
  }


  retry_join {
    leader_api_addr = "http://172.31.6.49:8200"
  }
}

listener "tcp" {
  address         = "0.0.0.0:8200"
  cluster_address = "0.0.0.0:8201"
  tls_disable     = 1
}

seal "awskms" {
  region     = "ap-south-1"
  kms_key_id = "f79404*******1c3cfac3"
}

cluster_addr = "http://172.31.1.110:8201"
api_addr     = "http://172.31.1.110:8200"
ui = true
EOF




// node 2

cat << EOF > /etc/vault.d/vault.hcl
storage "raft" {
  path    = "/opt/vault"
  node_id = "vault-node-2"

  retry_join {
    leader_api_addr = "http://172.31.1.110:8200"
  }


  retry_join {
    leader_api_addr = "http://172.31.6.49:8200"
  }
}

listener "tcp" {
  address         = "0.0.0.0:8200"
  cluster_address = "0.0.0.0:8201"
  tls_disable     = 1
}

seal "awskms" {
  region     = "ap-south-1"
  kms_key_id = "f7940434-6cdb-4f1c-b04a-7ad91c3cfac3"
}

cluster_addr = "http://172.31.14.77:8201"
api_addr     = "http://172.31.14.77:8200"
ui = true

EOF


// node 3

cat << EOF > /etc/vault.d/vault.hcl
storage "raft" {
  path    = "/opt/vault"
  node_id = "vault-node-3"

  retry_join {
    leader_api_addr = "http://172.31.1.110:8200"
  }


  retry_join {
    leader_api_addr = "http://172.31.14.77:8200"
  }
}

listener "tcp" {
  address         = "0.0.0.0:8200"
  cluster_address = "0.0.0.0:8201"
  tls_disable     = 1
}

seal "awskms" {
  region     = "ap-south-1"
  kms_key_id = "f7940434-6cdb-4f1c-b04a-7ad91c3cfac3"
}

cluster_addr = "http://172.31.6.49:8201"
api_addr     = "http://172.31.6.49:8200"
ui = true
EOF
