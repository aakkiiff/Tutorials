pipeline {
    agent {
        label 'test'
    }
    stages {
        stage('Hello') {
            steps {
                echo 'Hello World'
                sh 'hostname' 
            }
        }
    }
}
