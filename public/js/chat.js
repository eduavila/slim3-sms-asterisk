$(document)
  .ready(function(){

        Handlebars.registerHelper('if_eq', function(a, b, opts) {
            if(a == b) // Or === depending on your needs
                return opts.fn(this);
            else
                return opts.inverse(this);
        });

        Handlebars.registerHelper('formatTime', function (date, format) {
            var mmnt = moment(date);
            return mmnt.format(format);
        });
        
        var chat = {

            messageToSend: '',

            messageResponses: [],

            template: "{{#each mensagens}}"+
                      " <li id='{{this.id}}' data-type='{{this.status}}' class='content {{#if_eq this.status 'e' }}msg-right{{/if_eq}}'>"+
                      "   <a class='author'>"+
                      "     {{#if_eq this.status 'e'}}"+
                      "       {{this.interface}}"+
                      "     {{else}}"+
                      "        {{this.numero}}"+
                      "     {{/if_eq}}"+
                      "   </a>"+
                      "   <div class='metadata'> "+
                      "     <span class='date'>"+
                      "         {{#if_eq this.status 'r'}}<span class='interface'>{{this.interface}}</span>{{/if_eq}}"+ 
                      "         {{formatTime this.data 'DD-MM-YYYY'}} {{this.hora}}"+ 
                      "     </span>"+
                      "     <i class='checkmark icon {{#if_eq this.status_queue 'ERRO'}} remove {{else}} success {{/if_eq}}'></i>"+
                      "   </div>"+
                      "   <div class='text'>{{this.mensagem}}</div> "+
                      " </li>" + 
                      "{{/each}}",

            init: function(){

                //Carrega componetes
                this.cacheDOM();

                //Carrega Eventos
                this.bindEvents();

                // Renderiza msg.
                this.loadFullMensgens();

            
                this.getNewMessage();
            
            },

            cacheDOM: function(){
            
                //Componete Chat
                this.$chatHistory = $('.msg-historico');
                
                //INPUT NUMERO
                this.$numberTel = $('#numero');
                
                //Botao de envio
                this.$button = $('button');
            
                // Area texto
                this.$textarea = $('#usermsg');

                //Selecao do canal
                this.$select = $('#sel-interface');

                //Loader 
                this.$loader = $('.loader'); 
                
                // Lista de Historico
                this.$chatHistoryList = this.$chatHistory.find('ul');
            },

            // Set envento no botoes
            bindEvents: function(){
            
                // Evento de click
                this.$button.on('click', this.addMessage.bind(this));

                // Evento de enter
                this.$textarea.on('keyup', this.addMessageEnter.bind(this));
            
            },
            loadFullMensgens:function(){

                this.scrollToBottom();
            
                var template = Handlebars.compile(this.template);
            
                $.ajax({
                    url:'/mensagens/'+this.$numberTel.val()+'/json',
                    dataType:'json',
                    success:function(data){

                        if(data.length > 0){
                            var context = { mensagens: data};

                            $('.msg-historico').find('ul').html(template(context));
                            chat.setInterfaceDefault();
                        }
                    }
                });

                this.scrollToBottom();
            },

            addMessage:function(){

                this.messageToSend = this.$textarea.val();

                if(this.messageToSend.trim() !== ''){

                    var data = {"numero":this.$numberTel.val(),"interface":this.$select.val(),"mensagem":this.messageToSend};

                    $.ajax({
                        url:'/mensagens/'+this.$numberTel.val()+'/json',
                        dataType:'json',
                        method:'POST',
                        data:data,
                        success:function(data){              
                            $('.msg-historico').find('ul').apppend(template(context));
                        },error:function(){}});  

                    this.loadFullMensgens();     
                }
            },
            
            addMessageEnter: function(event){
                // Se for Enter
                if (event.keyCode === 13) {
                    this.addMessage();
                }
            },

            // busca por nova mensagens
            getNewMessage:function(){ 

                setInterval(function(){

                    var template = Handlebars.compile(chat.template);
                    var $msgHistoricoli = $('.msg-historico').find('ul > li').last();
                    var ultimaMsg = $msgHistoricoli.attr('id');

                    $.ajax({
                        url:'/mensagens/'+chat.$numberTel.val()+'/json?status=r&ultimamsg='+ultimaMsg,
                        dataType:'json',
                        success:function(data){

                            if(data.length > 0){
                                var context = { mensagens: data};

                                $('.msg-historico').find('ul').append(template(context));

                                chat.scrollToBottom();
                                                    
                                chat.setInterfaceDefault();
                            } 
                        },
                        error:function(){
                            console.log('error msg');
                        }
                    });
                },5000);    
            },

            scrollToBottom: function(){
                this.$chatHistory.animate({ scrollTop: 9999 }, 'slow');
            },

            setInterfaceDefault:function(){

                var $msgHistoricoli = $('.msg-historico').find('ul > li[data-type="r"]').last();

                if($msgHistoricoli)
                {
                    // busca ultima interface 
                    var interface  = $msgHistoricoli.find('.interface').html();
                    console.log(interface);

                    $('#sel-interface').dropdown('set selected', interface);
                }
            }
        };

        chat.init();
  });