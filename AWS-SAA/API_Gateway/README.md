# Post method
## create a dynamodb table
- name `user`
- partition key `email`

## create a lambda to put data
- create with a name
- python 3.12
- grant dynamodb write access
- use the code from the repo
- test an event 
```
{  "email":  "example@example.com",  "password":  "securepassword123"  }
```

## create an api gateway
- rest api
- post method
- test the same event from the request body
# GET method

## create a lambda to put data
- create with a name
- python 3.12
- grant dynamodb read access
- use the code from the repo


## create an api gateway
- rest api
- GET method
- enable proxy integration
- test the  query string parameter `email=email.com`
