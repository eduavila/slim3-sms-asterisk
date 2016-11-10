/**
 *
 * Plugin para busca live de messagens .
 * 
 */


(function($){
	
	// $.fn.listSimpleMsg = function(){

	// };
	//
	$.fn.listSimpleMsg = function(options){
		
		var self  = $(this);
		
		var numeroInicial = 0;
      	var pag = 1;
      	var numero = $("#numero").val();

		

		// var defaults = {
		// 	'corDeFundo':'yellow',
		// 	'iconLoader':'#loader'
		// 	'call'
		// };


		// Verifica se possui paramentro, caso nao possui atribui o default.
		// var settings = $.extend({},defaults,options);


      	// function renderHtml(msg){

        //   	var html = '<div class="comment">'+
        //                   '<div class="content">'+
        //                       '<a class="author">Matt</a>'+
        //                       '<div class="metadata"> '+
        //                           '<span class="date">'+ Date() + '/span>'+
        //                           '<i class="checkmark icon success"></i>' +
        //                       '</div>'+
        //                       '<div class="text">How artistic!</div> '+
        //                   '</div>'+
        //               '</div>';

        //   	return html;
      	// }


      	// var msg = {'teste':'teste'};


		// for(var i = 0; i < 20; i++){
		//   	$('.inner').prepend(msg);
		// }

      	// $("#chatBox").scrollTop($("#chatBox")[0].scrollHeight);

      
      	// setInterval(load, 2500);

		// function load(){
		  
		//   $.ajax({
		//       url:'/mensagens/'+numero+'/list',
		//       dataType:'html',
		//       success:function(data){
		//           $('.inner').html(renderHtml(data));
		//       }
		//   });

		// }


        // self.scroll(function(){

	    //     if(self.scrollTop() == 0)
	    //     {
	    //         // Display AJAX loader animation
	    //         $(settings.iconLoader).show();

	    //         $.ajax({
	    //             url:'/mensagens/'+numero+' /list ?offset='+pag,
	    //             dataType:'html',
	    //             success:function(data){
	                    
	    //                 $('.inner').prepend(renderHtml(data));
	               
	    //             }
	                
	    //         });     


	    //         $(settings.iconLoader).hide();

	    //         pag+=1;
        //   	}
        // });
	};

})(jQuery);