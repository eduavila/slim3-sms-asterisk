$(document)
  .ready(function(){

    // For responsive sidebar menu
    $("a.sidebar-toggle")
      .click(function(){
        $('.ui.sidebar').sidebar('toggle');
      });


    //Button
    $('.ui.checkbox')
      .checkbox()
      .change(function(item){

        event.preventDefault();
        
        if($(this).is('.checked'))
        {
          $("#nome").show();
        }else{
          $("#nome").hide();
        }
      }); 

      //Mascara
      $("input[name='phone']").keyup(function() {
          $(this).val($(this).val().replace(/^(\d{2})(\d{4})(\d)+$/, "($1)$2-$3"));
      });
      
      $('.message .close').on('click', function() {
          $(this).closest('.message').transition('fade');
      });

      function resizeGraphs() {
          var salesChart = $("#sales_chart");
          var table = $(".ui.table");
          salesChart.css("width", table.width());
      }

      function setupDoughnut(){

        var ctx = document.getElementById("doughnuts_are_tasty").getContext("2d");
        var data = [
          {
              value: 40,
              color:"#F7464A",
              highlight: "#FF5A5E",
              label: "Enviadas"
          },
          {
              value: 50,
              color: "#46BFBD",
              highlight: "#5AD3D1",
              label: "Recebidas"
          }
        ];

        var myDoughnutChart = new Chart(ctx).Doughnut(data,{});

        var legendHolder = document.getElementById('dashboard_legend');
        legendHolder.innerHTML = myDoughnutChart.generateLegend();

      }


      /**
       *
       *
       *  Java script para rendenriza messagens.
       *
       * 
       */
      $('#chatBox').listSimpleMsg();

      // Enviando Messagem.
    	$("#submitmsg").click(function(){
            var clientmsg = $("#usermsg").val();
      		
            var URL = "/mensagens/"+numero+"/enviar";

            $.post(URL, {text: clientmsg});				
      		
            $("#usermsg").attr("value", "");
      		
            return false;
    	});

    setupDoughnut();


    $(window).resize(function() {
      resizeGraphs();
    });
});