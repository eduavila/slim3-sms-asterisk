
####Exemplo configurançao do cron.
Executa a cada 2 minuto, e joga resultado no arquivo.
``*/2 * * * * php /Users/Eduardo/Documents/Projetos/sms_rafael/sms/app/Sms/QueueExec.php  >> /Users/Eduardo/Documents/Projetos/sms_rafael/smsteteCron.txt``

### Iniciar APACHE.
1. Criar pasta de projeto  `$ mkdir /var/www/`
2. Adicionar permisoes nas pasta
    `$ sudo chown -R $USER:$USER  /var/www/sms_asterisk/public`
    `$ sudo chmod -R 755 /var/www`
3. Criar arquivos virtual host
    sudo mkdir /etc/httpd/sites-available
    sudo mkdir /etc/httpd/sites-enabled

4. Configurar arquivos `$ vim /etc/httpd/conf/httpd.config`

~~~
<Directory "/var/www">
    Options Indexes FollowSymLinks
    AllowOverride All
    # Allow open access:
    Require all granted
</Directory>
~~~

### Iniciar instalação.
1. `$ git clone git clone https://eduavila@bitbucket.org/eduavila/sms_asterisk.git`
2. `$  php composer.phar install` Instalar dependencia PHP.
3. Browse to http://localhost:8888
