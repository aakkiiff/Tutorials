
### General Node Management

1.  **List all nodes in the cluster**:#

    `kubectl get nodes` 
    
2.  **Get detailed information about a specific node**:#
    
    `kubectl describe node <node-name>` 
    
3.  **Display node resources in YAML format**:
    
    
    `kubectl get node <node-name> -o yaml`
    
4.  **View resources and statuses of all nodes**:#

    `kubectl get nodes -o wide` 
    
5.  **Label a node**:
    
    `kubectl label node <node-name> <label-key>=<label-value>` 
    
6.  **Remove a label from a node**:
    
    
    `kubectl label node <node-name> <label-key>-`