$(document)
  .ready(function(){

    $('.datatable').DataTable({
        "language": {
            "sEmptyTable": "Nenhum registro encontrado",
            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
            "sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "_MENU_ resultados por página",
            "sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...",
            "sZeroRecords": "Nenhum registro encontrado",
            "sSearch": "Pesquisar",
            "oPaginate": {
                "sNext": "Próximo",
                "sPrevious": "Anterior",
                "sFirst": "Primeiro",
                "sLast": "Último"
            },
            "oAria": {
                "sSortAscending": ": Ordenar colunas de forma ascendente",
                "sSortDescending": ": Ordenar colunas de forma descendente"
            }
        }
      });

    
    
    
    // Sidebar 
    $("a.sidebar-toggle")
      .click(function(){
        $('.ui.sidebar').sidebar('toggle');
      });

    $("input:text").click(function(){
      $(this).parent().find("input:file").click();
    });

    // input de file
    $('input:file', '.ui.action.input')
      .on('change', function(e) {
        var name = e.target.files[0].name;
        $('input:text', $(e.target).parent()).val(name);
      });

    //Botao dropdown
    $('select.dropdown').dropdown();

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

      //Mascara Tel
      $("input[name='telefone']").keyup(function() {
          $(this).val($(this).val().replace(/^(\d{2})(\d{4})(\d)+$/, "($1)$2-$3"));
      });
      
      $('.message .close').on('click', function() {
          $(this).closest('.message').transition('fade');
      });



      // Grafico de mensagens
      function initChart(){

          var ctx = document.getElementById("chart_sms").getContext("2d");
          var $chart = $(chart_sms);

          var recebidas = parseFloat($chart.data("smsenviadas"));
          var enviadas = parseFloat($chart.data("smsrecebidas"));
          
          var pRecebida = (enviadas * 100)/ (recebidas + enviadas);
          var pEnviada =  (recebidas * 100)/ (recebidas + enviadas);

          var data = [
            {
                value: pEnviada,
                color:"#F7464A",
                highlight: "#FF5A5E",
                label: "Enviadas"
            },
            {
                value: pRecebida,
                color: "#46BFBD",
                highlight: "#5AD3D1",
                label: "Recebidas"
            }
          ];

        var myDoughnutChart = new Chart(ctx).Doughnut(data,{});

        // legenda..
        var leg = document.getElementById('dashboard_legend');

        leg.innerHTML = myDoughnutChart.generateLegend();
      }

      initChart();
});