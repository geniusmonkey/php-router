podTemplate(label: 'composer-php5', containers: [
    containerTemplate(name: 'composer', image: 'composer/composer:php5', ttyEnabled: true, command: 'cat')
  ]) {

    node ('composer-php5') {
        stage 'Checkout'
        checkout scm


        container('composer') {
            stage 'Install Dependencies'
            sh 'composer install'

            stage 'Unit Test'
            sh 'composer test'
            junit '**/test-results/*.xml'

        }

        // stage 'Get Project'
        // git 'https://github.com/jenkinsci/kubernetes-plugin.git'
        // container('maven') {
        //     stage 'Build a Maven project'
        //     sh 'mvn clean install'
        // }

        // stage 'Get a Golang project'
        // git url: 'https://github.com/hashicorp/terraform.git'
        // container('golang') {
        //     stage 'Build a Go project'
        //     sh """
        //     mkdir -p /go/src/github.com/hashicorp
        //     ln -s `pwd` /go/src/github.com/hashicorp/terraform
        //     cd /go/src/github.com/hashicorp/terraform && make core-dev
        //     """
        // }

    }
}