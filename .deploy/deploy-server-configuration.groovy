pipeline {
    agent any
    stages {
        stage('Deploy Server Configuration') {
            steps {
                sh 'cd .deploy/server && ansible-playbook -i hosts.ini --become --become-user=root server.yaml'
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
