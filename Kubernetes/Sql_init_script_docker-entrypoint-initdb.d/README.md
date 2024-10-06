# Using `docker-entrypoint-initdb.d` in Kubernetes Deployments for Database Initialization

## Introduction to `docker-entrypoint-initdb.d`

The `docker-entrypoint-initdb.d` is a feature available in certain Docker images for databases, such as MySQL and PostgreSQL. It allows you to place SQL scripts or initialization files in a specific directory within the Docker container. When the container starts up, the database system automatically executes these scripts, initializing the database with predefined data or configurations.

## DEMO:  Creating MySQL pod with preloaded database With  `docker-entrypoint-initdb.d`

 1. apply the config map `kubectl apply -f primary-execution-configmap.yml`
 2. apply the statefulset file `kubectl apply -f mysql-statefulset.yml`

## EXPLANATION:

***configmap***
the config map contains the init mysql commands

***mysql statefulset***
mount the volume to the /docker-entrypoint-initdb.d path.
