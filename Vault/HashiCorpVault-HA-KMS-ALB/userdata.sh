#!/bin/bash
# to uinzip vault installation file
apt-get install -y unzip

USER="vault"
COMMENT="Hashicorp vault user"
GROUP="vault"
HOME="/srv/vault"

# add vault user and group
sudo addgroup --system ${GROUP} >/dev/null
sudo adduser \
  --system \
  --disabled-login \
  --ingroup ${GROUP} \
  --home ${HOME} \
  --no-create-home \
  --gecos "${COMMENT}" \
  --shell /bin/false \
  ${USER}  >/dev/null

# download vault
cd /opt/ && sudo curl -o vault.zip https://releases.hashicorp.com/vault/1.13.1/vault_1.13.1_linux_amd64.zip

sudo unzip vault.zip
sudo mv vault /usr/local/bin/

mkdir -pm 0755 /etc/vault.d
sudo chown -R vault:vault /etc/vault.d

sudo mkdir /vault-data
sudo chown -R vault:vault /vault-data

# sudo mkdir -p /logs/vault/

mkdir -pm 0755 /opt/vault
chown vault:vault /opt/vault
chown vault:vault /usr/local/bin/vault

cat << EOF > /lib/systemd/system/vault.service
[Unit]
Description=Vault Agent
Requires=network-online.target
After=network-online.target
[Service]
Restart=on-failure
PermissionsStartOnly=true
ExecStartPre=/sbin/setcap 'cap_ipc_lock=+ep' /usr/local/bin/vault
ExecStart=/usr/local/bin/vault server -config /etc/vault.d
ExecReload=/bin/kill -HUP $MAINPID
KillSignal=SIGTERM
User=vault
Group=vault
[Install]
WantedBy=multi-user.target
EOF