#old
# # to uinzip vault installation file
# apt-get install -y unzip

# USER="vault"
# COMMENT="Hashicorp vault user"
# GROUP="vault"
# HOME="/srv/vault"

# # add vault user and group
# sudo addgroup --system ${GROUP} >/dev/null
# sudo adduser \
#   --system \
#   --disabled-login \
#   --ingroup ${GROUP} \
#   --home ${HOME} \
#   --no-create-home \
#   --gecos "${COMMENT}" \
#   --shell /bin/false \
#   ${USER}  >/dev/null

# # download vault
# cd /opt/ && sudo curl -o vault.zip https://releases.hashicorp.com/vault/1.13.1/vault_1.13.1_linux_amd64.zip
# # cd /opt/ && sudo curl -o vault.zip https://releases.hashicorp.com/vault/1.20.2/vault_1.20.2_darwin_amd64.zip

# sudo unzip vault.zip
# sudo mv vault /usr/local/bin/

# mkdir -pm 0755 /etc/vault.d
# sudo chown -R vault:vault /etc/vault.d

# sudo mkdir /vault-data
# sudo chown -R vault:vault /vault-data

# # sudo mkdir -p /logs/vault/

# mkdir -pm 0755 /opt/vault
# chown vault:vault /opt/vault
# chown vault:vault /usr/local/bin/vault

# cat << EOF > /lib/systemd/system/vault.service
# [Unit]
# Description=Vault Agent
# Requires=network-online.target
# After=network-online.target
# [Service]
# Restart=on-failure
# PermissionsStartOnly=true
# ExecStartPre=/sbin/setcap 'cap_ipc_lock=+ep' /usr/local/bin/vault
# ExecStart=/usr/local/bin/vault server -config /etc/vault.d
# ExecReload=/bin/kill -HUP $MAINPID
# KillSignal=SIGTERM
# User=vault
# Group=vault
# [Install]
# WantedBy=multi-user.target
# EOF


# cat << EOF > /etc/vault.d/vault.hcl
# storage "file" {
#   path = "/opt/vault"
# }
# listener "tcp" {
#   address     = "0.0.0.0:8200"
#   tls_disable = 1
# }
# seal "awskms" {
#   region     = "ap-south-1"
#   kms_key_id = "d6913ebf-cbb3-4ceb-9ecd-113d8acced70"
# }
# ui=true
# EOF



# sudo chmod 0664 /lib/systemd/system/vault.service
# systemctl daemon-reload
# sudo chmod -R 0644 /etc/vault.d/*
# chmod 0755 /usr/local/bin/vault


# cat << EOF > /etc/profile.d/vault.sh
# export VAULT_ADDR=http://127.0.0.1:8200
# export VAULT_SKIP_VERIFY=true
# EOF



# systemctl enable vault
# systemctl start vault
# export VAULT_ADDR=http://127.0.0.1:8200


#NEW
