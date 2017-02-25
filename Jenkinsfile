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
    }
}