# 🚀 Istio Installation On K8s Cluster Guide
![enter image description here](./assets/istio.svg)

### 🖥 Environment
- 2 node kuberentes cluster
	- Master | CPU cores 2 | RAM 4GB
	- Worker | CPU cores 2 | RAM 4GB
- Istio Version 1.27
## ⚡Steps
### Step 1 | Install Istio's CRD's 🛠
```
helm upgrade --install istio-base istio/base \
  --version 1.27.0 \
  -n istio-system \
  --create-namespace
```
> 📚Reference 
> https://artifacthub.io/packages/helm/istio-official/base

### Step 2 | Deploy Istiod Control Plane🛠

```
helm upgrade --install istiod istio/istiod \
  --version 1.27.0 \
  -n istio-system \
  --wait \
  --set global.proxy.autoInject=enabled \
  --set global.proxy.logLevel=warning
```
> 📚Reference 
> https://artifacthub.io/packages/helm/istio-official/istiod

### Step 3 | Verify✅
```
kubectl get pod -n istio-system
```
#### Output
```
NAME                     READY   STATUS    RESTARTS   AGE
istiod-bfbb879dc-tltd4   1/1     Running   0          2m31s
``` 	

### Step 4 | Label Namespaces🏷
- Label the namespaces, Where you want to inject envoy sidecar
```
kubectl label namespace <namespace-name> istio-injection=enabled
```
### Step 5 | Run Workload📦
- Newly created workload will be automatically have envoy sidecar injected
```
kubectl create deployment test-deployment --image nginx
```
- If you have workload running previously, (create before namespace labeling), Simply restart them to have envoy sidecar injected
```
kubectl rollout restart deployment test 
```

### Step 6 | Verify✅
- Pods should have a istio-proxy sidecar running
```
kubectl get pods  -o jsonpath="{range .items[*]}{range .spec.containers[*]}{.name}{'\n'}{end}{end}"
```
#### Output
```
nginx
istio-proxy     <---------- SHOULD BE PRESENT
```
<hr>

## 📊Install Kiali And Prometheus To View Dashboard
To view dynamic dashboard of service map install kiali and prometheus
 ### Install Prometheus (Development purpose installation)
```
helm install prometheus prometheus-community/prometheus -n istio-system --set alertmanager.persistentVolume.enabled=false --set server.persistentVolume.enabled=false
```
### Install Kiali Server🎛
```
helm install kiali-server kiali/kiali-server -n istio-system \
  --set auth.strategy="anonymous" \
  --set external_services.prometheus.url="http://prometheus-server.istio-system.svc.cluster.local"
```

### Portforward🌐
```
 kubectl port-forward -n istio-system kiali-pod-id 20001:20001
```
> Browse http://localhost:20001

<hr>

### 📜Enable Istio-proxy(Envoy) sidecar access logs
```
apiVersion: telemetry.istio.io/v1
kind: Telemetry
metadata:
  name: mesh-default
  namespace: istio-system
spec:
  accessLogging:
    - providers:
      - name: envoy
```

### 🔐Enable mTLS
```
apiVersion: security.istio.io/v1beta1
kind: PeerAuthentication
metadata:
  name: default
  namespace: <namespace your want to enable mTLS>
spec:
  mtls:
    mode: STRICT
```
