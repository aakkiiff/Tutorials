pipeline {
    agent any 
    
    stages {
        stage('Stage 1') {
            agent {
                label 'test'
            }
            steps {
                echo 'Running Stage 1 on node labeled "test"'
                sh 'hostname'
            }
        }
        stage('Stage 2') {
            agent {
                label 'sad'
            }
            steps {
                echo 'Running Stage 2 on node labeled "sad"'
                sh 'hostname'
            }
        }

    }
    
}
