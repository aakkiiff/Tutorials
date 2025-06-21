#!/bin/bash

AWS_CREDENTIALS_FILE=~/.aws/credentials
AWS_CONFIG_FILE=~/.aws/config

function add_profile() {
    read -p "Enter profile name: " profile
    read -p "AWS Access Key ID: " access_key
    read -s -p "AWS Secret Access Key: " secret_key
    echo ""
    read -p "Default region (e.g. ap-southeast-1): " region

    mkdir -p ~/.aws
    
    # Check if the given profile already exists
    if grep -q "^\[$profile\]" "$AWS_CREDENTIALS_FILE" 2>/dev/null || \
       grep -q "^\[profile $profile\]" "$AWS_CONFIG_FILE" 2>/dev/null; then
        echo "❌ Profile '$profile' already exists."
        return
    fi

    # Add aws_access_key_id aws_secret_access_key to credentials file
    {
        echo "[$profile]"
        echo "aws_access_key_id = $access_key"
        echo "aws_secret_access_key = $secret_key"
        echo ""
    } >> "$AWS_CREDENTIALS_FILE"

    # Add region to config file
    {
        echo "[profile $profile]"
        if [ -n "$region" ]; then
            echo "region = $region"
        fi
        echo ""
    } >> "$AWS_CONFIG_FILE"

    echo "✅ Profile '$profile' added successfully."
}
