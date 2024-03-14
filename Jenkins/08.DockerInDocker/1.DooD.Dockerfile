#jenkins with dokcer cli
#docker run -p 8080:8080 -p 50000:50000 --detach --restart always -v /var/jenkins_home:/var/jenkins_home  -v /var/run/docker.sock:/var/run/docker.sock jenkins-dind
FROM jenkins/jenkins
USER root
RUN apt-get update -qq \
 && apt-get install -qqy apt-transport-https ca-certificates curl gnupg2 software-properties-common
RUN curl -fsSL https://download.docker.com/linux/debian/gpg | apt-key add -
RUN add-apt-repository \
   "deb [arch=amd64] https://download.docker.com/linux/debian \
   $(lsb_release -cs) \
   stable"
RUN apt-get update  -qq \
 && apt-get -y install docker-ce
RUN usermod -aG docker jenkins