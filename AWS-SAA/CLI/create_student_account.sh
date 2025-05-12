#!/bin/bash
names=("name1" "name2" "name3")
batch_name="batch1"
group_name="AWS-SAA-BATCH-1"
password="*5ka2sUasd!FJ"

if ! aws iam get-group --group-name "$group_name" &>/dev/null; then
    aws iam create-group --group-name "$group_name"
    echo "Group '$group_name' created successfully"
else
    echo "Group '$group_name' already exists"
fi

for name in "${names[@]}"; do
    name="${name}-${batch_name}"
    aws iam create-user --user-name "$name"
    echo "$name User created successfully"

    aws iam create-login-profile --user-name "$name" --password "$password"  --password-reset-required
    echo "$name console access granted"

    aws iam add-user-to-group --user-name "$name" --group-name "$group_name"
    echo "$name added to group"
    echo "___________________Next___________________"
done

#dont forget to add permission to the group