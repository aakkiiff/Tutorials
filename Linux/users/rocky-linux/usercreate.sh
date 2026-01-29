#!/bin/bash
set -euo pipefail

read -rp "Enter username to create: " USER

[[ -z "$USER" ]] && { echo "❌ Username cannot be empty"; exit 1; }

if [[ ! "$USER" =~ ^[a-z_][a-z0-9_-]{0,31}$ ]]; then
    echo "❌ Invalid username format"
    exit 1
fi

echo "Paste the PRIVATE PEM key now."
echo "When finished, press CTRL+D"
PEM_FILE=$(mktemp)

cat > "$PEM_FILE"

# Validate PEM
if ! grep -q "BEGIN.*PRIVATE KEY" "$PEM_FILE"; then
  echo "❌ Invalid PEM key format"
  rm -f "$PEM_FILE"
  exit 1
fi

# Convert PEM → public key
SSH_PUB_KEY=$(ssh-keygen -y -f "$PEM_FILE" 2>/dev/null || true)

rm -f "$PEM_FILE"

if [[ -z "$SSH_PUB_KEY" ]]; then
  echo "❌ Failed to convert PEM key to public key"
  exit 1
fi

HOME_DIR="/home/$USER"
SSH_DIR="$HOME_DIR/.ssh"
SUDOERS_FILE="/etc/sudoers.d/$USER"

echo "==> Creating user if not present..."
if id "$USER" &>/dev/null; then
  echo "User $USER already exists"
else
  useradd -m -s /bin/bash "$USER"
  echo "User $USER created"
fi

echo "==> Configuring passwordless sudo..."
# echo "$USER ALL=(ALL) NOPASSWD: ALL" > "$SUDOERS_FILE"
cat > "$SUDOERS_FILE" << EOF
# Passwordless sudo for $USER except full root shells
$USER ALL=(ALL) NOPASSWD: ALL, !/bin/su, !/usr/bin/sudo -i, !/usr/bin/sudo su
EOF
chmod 440 "$SUDOERS_FILE"

echo "==> Setting up SSH..."
mkdir -p "$SSH_DIR"

echo "$SSH_PUB_KEY" > "$SSH_DIR/authorized_keys"

chown -R "$USER:$USER" "$SSH_DIR"
chmod 700 "$SSH_DIR"
chmod 600 "$SSH_DIR/authorized_keys"

echo "✅ User $USER configured successfully"
echo "🔐 SSH public key installed (converted from PEM)"
