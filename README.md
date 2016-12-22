
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



####Configuraçao asterisk
~~~
exten => sms,1,Verbose(Recebendo SMS deM ${CALLERID(num)} ${BASE64_DECODE(${SMS_BASE64})})                                                
;exten => sms,n,System(echo '${STRFTIME(${EPOCH},,%Y-%m-%d %H:%M:%S)} - ${DONGLENAME} -  ${CALLERID(num)}:  ${BASE64_DECODE(${SMS_BASE64})}' >> /var/log/ast
erisk/sms.txt)
exten => sms,n,System(mysql -u root -p03496610 -D sms_aste -e "INSERT INTO mensagens (status,data,hora,interface,numero,mensagem) VALUES ('r','${STRFTIME(${EPOCH
},,%Y-%m-%d)}','${STRFTIME(${EPOCH},,%H:%M:%S)}','${DONGLENAME}','${CALLERID(num)}','${SMS_BASE64}')")
exten => sms,n,Hangup()

~~~