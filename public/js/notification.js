 var notify = function(){

        if(!window.Notification) {
          console.log('Este browser não suporta Web Notifications!');
          return;
        }

        if (Notification.permission === 'default') {
          
          Notification.requestPermission(function() {
            console.log('Usuário não falou se quer ou não notificações. Logo, o requestPermission pede a permissão pra ele.');
          });

        } else if (Notification.permission === 'granted') {
            console.log('Usuário deu permissão');
            
            var notification = new Notification('O título da Notifcação', {
             body: 'Mensagem do corpo da notificação',
             tag: 'string única que previne notificações duplicadas',
            });
            notification.onshow = function() {
             console.log('onshow: evento quando a notificação é exibida')
            },
            notification.onclick = function() {
             console.log('onclick: evento quando a notificação é clicada');
            },
            notification.onclose = function() {
             console.log('onclose: evento quando a notificação é fechada')
            },
            notification.onerror = function() {
             console.log('onerror: evento quando a notificação não pode ser exibida. É disparado quando a permissão é defualt ou denied')
            }
            
        } else if (Notification.permission === 'denied') {
          console.log('Usuário não deu permissão');
        }

    };