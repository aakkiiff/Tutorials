#!/bin/bash
names=("name1" "name2" "name3")

for name in "${names[@]}"; do
    aws iam create-user --user-name "$name"
    echo "$name User created successfully"

    aws iam create-login-profile --user-name "$name" --password "*5ka2sUasd!FJ" --password-reset-required
    echo "$name console access granted"

    aws iam add-user-to-group --user-name "$name" --group-name AWS-SAA-Students
    echo "$name added to group"
    echo "___________________Next___________________"
done
