# creating a user

ref: https://kubernetes.io/docs/reference/access-authn-authz/certificate-signing-requests/

# steps:
## generate certificate file

- create private key and certificate signing request file
```shell
openssl genrsa -out newuser.key 2048
openssl req -new -key newuser.key -out newuser.csr -subj "/CN=newuser"
```
- Create a CertificateSigningRequest (csr.yaml)

```shell
apiVersion: certificates.k8s.io/v1
kind: CertificateSigningRequest
metadata:
  name: newuser
spec:
  request: <csr _______ data>
  signerName: kubernetes.io/kube-apiserver-client
  expirationSeconds: 86400  # one day
  usages:
  - client auth
```
```
kubectl apply -f csr.yaml 
```
Some points to note:

--   `usages`  has to be '`client auth`'
--   `request`  is the base64 encoded value of the CSR file content. You can get the content using this command:
    
```shell
cat newuser.csr | base64 | tr -d "\n"
```
    

- Approve the CertificateSigningRequest

Get the list of CSRs:

```shell
kubectl get csr
```

Approve the CSR:

```shell
kubectl certificate approve newuser
```


- Get the certificate

```shell
kubectl get csr newuser -o jsonpath='{.status.certificate}'| base64 -d > newuser.crt
```


## Create Role and RoleBinding

- Create Role and RoleBinding
- 
This is a  command to create a Role for this new user:

```shell
kubectl create role developer --verb=create --verb=get --verb=list --verb=update --verb=delete --resource=pods
```

This is a command to create a RoleBinding for this new user:

```shell
kubectl create rolebinding developer-binding-myuser --role=developer --user=newuser
```


## Add to kubeconfig

First, you need to add new credentials:

```shell
kubectl config set-credentials newuser --client-key=newuser.key --client-certificate=newuser.crt --embed-certs=true
```

Then, you need to add the context:

```shell
kubectl config set-context newuser --cluster=kubernetes --user=newuser

```

To test it, change the context to  `newuser`:

```shell
kubectl config use-context newuser
```