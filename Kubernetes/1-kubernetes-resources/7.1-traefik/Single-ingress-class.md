
# Traefik Ingress Installation

**Check out the official docs here:** [official documentation](https://doc.traefik.io/traefik/reference/routing-configuration/kubernetes/ingress/)
## Install
### add,update and get repo version
```
helm repo add traefik https://traefik.github.io/charts
helm repo update
```
### Install Traefik Ingress Controller
```
helm install traefik traefik/traefik
```
This deploys **one Traefik Ingress Controller** with **one LoadBalancer Service**, meaning MetalLB will assign **a single IP** to this controller.

### Create ingress file
```
apiVersion: networking.k8s.io/v1
kind: Ingress
metadata:
  name: default-test
  namespace: default
  annotations:
    ingress.class: "traefik"
spec:
  rules:
  - http:
      paths:
      - path: /
        pathType: Prefix
        backend:
          service:
            name: apisix-dashboard
            port:
              number: 80
```
```
NAMESPACE↑                  NAME                          CLASS                    HOSTS                 ADDRESS                         PORTS                 AGE                    │
default                     default-test                  traefik                  *                     192.168.61.204                  80                    16m      
```

## ➤ **Important Notes**

### ✔ 1. Single Traefik controller = Single LoadBalancer IP

When you use **one Traefik controller**, it exposes **one LoadBalancer Service**, so MetalLB assigns **one IP only**.

### ✔ 2. Hostnames still work normally

Even with one IP, you can expose unlimited applications using **different hostnames**:
- test1.foodibd.net → app A
- test2.foodibd.net → app B
- api.foodibd.net → app C
Routing happens via **Hostname** , so this is fully supported and correct.

  

### ✔ 3. Multi-IP ingress exposure **is possible**, but requires multiple controllers

If you want different applications to use **different external IPs**, you must deploy **multiple Traefik Ingress controllers**, for example:
-  `traefik-a` → gets IP 192.168.61.204
-  `traefik-b` → gets IP 192.168.61.205
Each controller has its own `ingress.class`.
This is the only way to achieve multi-IP behavior using HAProxy or Traefik.

### ✔ 4. With a single controller, multi-IP is **not** possible
Because Kubernetes maps:
**Ingress → IngressClass → Controller Deployment → LoadBalancer Service → MetalLB IP**
One controller = one service = one IP.
