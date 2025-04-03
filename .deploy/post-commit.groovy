pipeline {
    agent any
    stages {
        stage('Composer Install') {
            steps {
                sh 'composer install'
            }
        }
        stage('Npm Install') {
            steps {
                sh 'npm install --no-color'
            }
        }
        stage('Npm Run Build') {
            steps {
                sh 'npm run build'
            }
        }
        stage('Preparing Testing Tools') {
            steps {
                sh 'wget -O phpunit https://phar.phpunit.de/phpunit-12.phar && chmod +x phpunit'
                sh 'wget -O psalm https://github.com/vimeo/psalm/releases/download/6.8.8/psalm.phar && chmod +x psalm'
                sh 'wget -O infection https://github.com/infection/infection/releases/download/0.29.12/infection.phar && chmod +x infection'
            }
        }
        stage('Run PHPUnit Tests') {
            steps {
                sh 'php phpunit --log-junit reports/phpunit/phpunit.xml --coverage-clover reports/phpunit/coverage.xml --coverage-html reports/phpunit/coverage --coverage-xml reports/infection/coverage/coverage-xml'
            }
            post {
                always {
                    junit 'reports/phpunit/phpunit.xml'
                    publishHTML(target: [allowMissing: false, alwaysLinkToLastBuild: false, keepAll: true, reportDir: 'reports/phpunit/coverage', reportFiles: 'index.html', reportName: "Coverage Report"])
                    step([
                        $class: 'CloverPublisher',
                        cloverReportDir: 'reports/phpunit',
                        cloverReportFileName: 'coverage.xml',
                        healthyTarget: [methodCoverage: 100, conditionalCoverage: 100, statementCoverage: 100],
                        failingTarget: [methodCoverage: 100, conditionalCoverage: 100, statementCoverage: 100]
                    ])
                }
            }
        }
        stage('Run Psalm') {
            steps {
                sh "php psalm --threads=4 --no-cache --report=reports/psalm/psalm.checkstyle.xml --show-info=true"
            }
            post {
                always {
                    recordIssues(enabledForFailure: true, tools: [checkStyle(id: 'psalm', name: 'Psalm', pattern: 'reports/psalm/psalm.checkstyle.xml', reportEncoding: 'UTF-8')])
                }
            }
        }
        stage('Run Infection') {
            steps {
                sh 'chmod a+rw -R reports && cp reports/phpunit/phpunit.xml reports/infection/coverage/junit.xml'
                sh 'php infection --threads=4 --min-covered-msi=100 --no-progress --coverage=reports/infection/coverage --skip-initial-tests'
            }
            post {
                always {
                    archiveArtifacts artifacts: 'var/log/infection.log', fingerprint: true
                    publishHTML(target: [allowMissing: false, alwaysLinkToLastBuild: false, keepAll: true, reportDir: 'public/infection', reportFiles: 'index.html', reportName: "Infection Report"])
                }
            }
        }
        stage('Run Jest') {
            steps {
                sh 'npm run test'
            }
            post {
                always {
                    publishHTML(target: [allowMissing: false, alwaysLinkToLastBuild: false, keepAll: true, reportDir: 'assets/website/ts/coverage/', reportFiles: 'index.html', reportName: "Coverage Report"])
                    step([
                        $class: 'CloverPublisher',
                        cloverReportDir: 'reports/jest',
                        cloverReportFileName: 'coverage.xml',
                        healthyTarget: [methodCoverage: 100, conditionalCoverage: 100, statementCoverage: 100],
                        failingTarget: [methodCoverage: 100, conditionalCoverage: 100, statementCoverage: 100]
                    ])
                }
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
