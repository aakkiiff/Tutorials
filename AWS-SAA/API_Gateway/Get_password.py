import json
import boto3

dynamodb = boto3.resource('dynamodb')
table = dynamodb.Table('users')
 
def lambda_handler(event, context):
    try:
        print(event)
        email = event["queryStringParameters"]["email"]
        # Checking if emails is in the table
        response = table.get_item(Key={'email': email})

        if 'Item' in response:
            password = response['Item']['password']
            return {
                'statusCode': 200,
                'body': f'your password is {password}'
            }
        else:
            return {
                'statusCode': 404,
                'body': json.dumps({'error': 'Email not found'})
            }

    except Exception as e:
        return {
            'statusCode': 500,
            'body': json.dumps({'error': str(e)})
        }
