
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




####Configurando CRON.
1. `$ crontab -e`
2. `*/2 * * * * php /var/www/sms_asterisk/app/Sms/QueueExec.php  >> /var/www/sms_asterisk/log/cron/crontab.log`