pipeline {
    agent any
    stages {
        stage('Install Deployer') {
            steps {
                sh 'cd .deploy && composer install'
            }
        }
        stage('Deploy Prod') {
            steps {
                sh 'cd .deploy && php vendor/bin/dep -f deploy.php deploy:unlock production'
                sh 'cd .deploy && php vendor/bin/dep -f deploy.php deploy'
            }
        }
    }
    post {
        always {
            cleanWs(cleanWhenAborted: true, cleanWhenFailure: true, cleanWhenNotBuilt: true, cleanWhenUnstable: true)
            dir("${env.WORKSPACE}@tmp") {
                deleteDir()
            }
        }
    }
}
