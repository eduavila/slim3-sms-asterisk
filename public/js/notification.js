$(document)
  .ready(function(){

      var notificacao = {

            init:function(){

                // Verifica se tem suporte
                if(!window.Notification){
                    console.log('Este browser não suporta Web Notifications!');
                    return;
                }

                Notification.requestPermission(function(){
                    console.log('Usuário não falou se quer ou não notificações. Logo, o requestPermission pede a permissão pra ele.');
                });
                  
                // Verifica se existe nova mensagem. 
                setInterval(function(){
                    
                    $.ajax({
                        url:'/mensagens/recebida/total',
                        dataType:'json',
                        method:'GET',
                        success:function(data){              
                            
                            var qtdMSG = parseInt($('#msg-recebida').val());         
                            
                            var qtdRecebida = (data.tot_recebida - qtdMSG);

                            if(qtdRecebida > 0){
                                
                                if(Notification.permission === 'granted'){
                                    var notification = new Notification('Novo SMS recebido.',{body: qtdRecebida + " Nova Mensagens",icon:"/img/ico_sms.png"});

                                    notification.onclick = function(){
                                        console.log('onclick: evento quando a notificação é clicada');
                                        location.href="/mensagens";
                                    };

                                    // atualiza campo.
                                    $("#msg-recebida").val(data.tot_recebida);

                                    $(".msg-recebida").html(data.tot_recebida);
                                    $(".msg-tot").html(data.tot_recebida);
                                }
                            }
                        }
                    });              
                         
                },6000); 
            }
        };

      
      // Inicia notificação
      notificacao.init();

  });