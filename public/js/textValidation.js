$(document)
  .ready(function(){

    var validation = {

        init: function(){
            //Carrega componetes
            this.cacheDOM();

            //Carrega Evetos
            this.bindEvents();
        },

        cacheDOM: function(){
            //Componete Chat
            this.$fieldText = $('.numeros');

            this.$alert = $('alert');
        },

        // Set envento no botoes
        bindEvents: function(){
        
            // Evento de leave
            this.$fieldText.on('leave', this.addMessage.bind(this));
        },

        validation:function(){
            
        },
        showAlert:function(msg){
            
        }
    };
  
    validation.init();
});