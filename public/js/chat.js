$(document)
  .ready(function(){

    Handlebars.registerHelper('if_eq', function(a, b, opts) {
      if(a == b) // Or === depending on your needs
          return opts.fn(this);
      else
          return opts.inverse(this);
    });

  var chat = {

    messageToSend: '',

    messageResponses: [
    {
      "id": "4",
      "status": "r",
      "data": "2016-08-16",
      "hora": "20:57:05",
      "interface": "dongle4",
      "numero": "1515",
      "mensagem": "Pre Diario: Vc enviou um SMS e agora tem 300 SMS p/ Vivo, 15 SMS p/outras e o DOBRO de internet, de 15MB p/ 30MB ate 23h59 por R\u00020,99"
    },
    {
      "id": "21",
      "status": "e",
      "data": "2016-08-17",
      "hora": "08:51:20",
      "interface": "dongle4",
      "numero": "1515",
      "mensagem": "Pre Diario: Vc enviou um SMS e agora tem 300 SMS p/ Vivo, 15 SMS p/outras e o DOBRO de internet, de 15MB p/ 30MB ate 23h59 por R\u00020,99"
    }
  ],

  template: " {{#each mensagens}}"+
            "<li class='content {{#if_eq this.status 'e' }}msg-right{{/if_eq}}'>"+
             "   <a class='author'>{{this.numero}}</a>"+
             "  <div class='metadata'> "+
             "   <span class='date'>{{this.data}} {{this.hora}}</span>"+
             "     <i class='checkmark icon success'></i>"+
             "   </div>"+
             "       <div class='text'>{{this.mensagem}}</div> "+
             " </li>" + 
             "{{/each}}",


  init: function(){
      //Carrega componetes
      this.cacheDOM();

      //Carrega Evetos
      this.bindEvents();

      // Rendezia msg.
      //this.render();

      this.loadFullMensgens();
    },

    cacheDOM: function() {
      
      //Componete Chat
      this.$chatHistory = $('.msg-historico');

      //Botao de envio
      this.$button = $('button');
      
      // Area texto
      this.$textarea = $('#message-to-send');

      //Selecao do canal
      this.$select = $('select');

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
        
        var context = { mensagens: this.messageResponses};
       
        this.$chatHistoryList.append(template(context));
    
        this.scrollToBottom();

        // setTimeout(function() {

      

        // }.bind(this), 1500);
    },
    
    // Renderiza Chat
    render: function() {

      this.scrollToBottom();
      
      if(this.messageToSend.trim() !== ''){

        var template = Handlebars.compile( $("#message-template").html());
        
        var context = {

          mensagens:this.messageResponses,
          time: this.getCurrentTime()
          
        };

        this.$chatHistoryList.append(template(context));
        this.scrollToBottom();
        this.$textarea.val('');
        
        // RESPOSTA
        var templateResponse = Handlebars.compile(template);
       
        var contextResponse = {
          mensagens: this.messageResponses
        };
        
        setTimeout(function() {

          this.$chatHistoryList.append(templateResponse(contextResponse));
          this.scrollToBottom();

        }.bind(this), 1500);
      }
      
    },
    
    addMessage: function() {
      this.messageToSend = this.$textarea.val();

      this.render();   
    },

    addMessageEnter: function(event){
        // Se for Enter
        if (event.keyCode === 13) {
          this.addMessage();
        }
    },

    scrollToBottom: function() {
       this.$chatHistory.scrollTop(this.$chatHistory.scrollHeight);
    },

    getCurrentTime: function() {
      return new Date().toLocaleTimeString().
              replace(/([\d]+:[\d]{2})(:[\d]{2})(.*)/, "$1$3");
    }
  };
  
  chat.init();





  // // busca no chat
  // var searchFilter = {

  //   options: { valueNames: ['name'] },
   
  //   init: function() {

  //     var userList = new List('people-list', this.options);
  //     var noItems = $('<li id="no-items-found">Nenhuma messagen encontrada</li>');
      
  //     userList.on('updated', function(list) {
  //       if (list.matchingItems.length === 0) {
  //         $(list.list).append(noItems);
  //       } else {
  //         noItems.detach();
  //       }
  //     });

  //   }

  // };
  
  //searchFilter.init();
  
});



  // self.scroll(function(){

  //   if(self.scrollTop() == 0)
  //   {
  //       // Display AJAX loader animation
  //       $(settings.iconLoader).show();

  //       $.ajax({
  //           url:'/mensagens/'+numero+' /list?offset='+pag,
  //           dataType:'html',
  //           success:function(data){
  //               $('.inner').prepend(renderHtml(data));
  //           }
  //       });     


  //       $(settings.iconLoader).hide();

  //       pag+=1;
  //    }
  // });


      /**
       *
       *
       *  Java script para rendenriza messagens.
       *
       * 
       */



      // function renderHtml(msg){

      //    var html = '<div class="comment">'+
      //                   '<div class="content">'+
      //                       '<a class="author">Matt</a>'+
      //                       '<div class="metadata"> '+
      //                           '<span class="date">'+ Date() + '</span>'+
      //                           '<i class="checkmark icon success"></i>' +
      //                       '</div>'+
      //                       '<div class="text">TESTE 34343 34343 </div> '+
      //                   '</div>'+
      //               '</div>';

      //    return html;
      // }

      // $("#chatBox").scrollTop($("#chatBox")[0].scrollHeight);

      // setInterval(load, 9000);

      // var numero = $("")

      // function load(){
        
      //   $.ajax({
      //       url:'/mensagens/'+numero+'/list',
      //       dataType:'html',
      //       success:function(data){
              
      //         // if(data.length > 0 )
      //         // {
      //         //   notify();
      //         // }

      //         $('.inner').html(renderHtml(data));
      //       }
      //   });
      // }
      
      // // Enviando Messagem.
    	// $("#submitmsg").click(function(){
      //       var clientmsg = $("#usermsg").val();
      		
      //       var URL = "/mensagens/"+numero+"/enviar";

      //       $.post(URL, {text: clientmsg});				
      		
      //       $("#usermsg").attr("value", "");
      		
      //       return false;
    	// });