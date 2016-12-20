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

    messageResponses: [],

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
        this.loadFullMensgens();

    },

    cacheDOM: function() {
      
      //Componete Chat
      this.$chatHistory = $('.msg-historico');

      this.$numberTel = $('#numero');
      //Botao de envio
      this.$button = $('button');
      
      // Area texto
      this.$textarea = $('#usermsg');

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
        
         //Display AJAX loader animation
       
        $("#loader").show();

        $.ajax({
            url:'/mensagens/'+this.$numberTel.val()+'/json',
            dataType:'json',
            success:function(data){
                if(data.length > 0){
                    var context = { mensagens: data};
                    $('.msg-historico').find('ul').html(template(context));
                }
            
                $("#loader").hide();
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

              }
          });    
          this.loadFullMensgens();     
      }
    },
    
    addMessageEnter: function(event){
        // Se for Enter
        if (event.keyCode === 13) {
          this.addMessage();
        }
    },

    scrollToBottom: function() {
       this.$chatHistory.scrollTop(this.$chatHistory.scrollHeight);
    }
  
};
  
chat.init();

setInterval(function(){
    chat.loadFullMensgens();
}, 5000);



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
  //      

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