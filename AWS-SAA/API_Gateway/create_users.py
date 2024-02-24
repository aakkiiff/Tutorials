import boto3

dynamodb = boto3.resource('dynamodb')
table= dynamodb.Table('users')
def lambda_handler(event, context):
    
    print("###########event##########")
    print(event)
    email=event['email']
    password=event['password']
    print(email)
    print(password)
    
    response = table.put_item(Item={
        'email':email,
        'password':password
    })

    return {
        'statusCode': 200,
        'body': f'user: {email} created successfully'
    }
    
