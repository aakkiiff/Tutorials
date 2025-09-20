docker run --name sonarqube-custom -p 9000:9000 sonarqube


#scan locally
sonar-scanner \
  -Dsonar.projectKey=test1 \
  -Dsonar.sources=. \
  -Dsonar.host.url=http://localhost:9000 \
  -Dsonar.token=sqp_935d0bd7456ef6d4a9818df7bfb66338c81440c8