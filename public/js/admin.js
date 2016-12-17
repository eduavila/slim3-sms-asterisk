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

    $('.ui.dropdown').dropdown();
    
    // Sidebar 
    $("a.sidebar-toggle")
      .click(function(){
        $('.ui.sidebar').sidebar('toggle');
      });

    $("input:text").click(function() {
      $(this).parent().find("input:file").click();
    });

    $('input:file', '.ui.action.input')
      .on('change', function(e) {
        var name = e.target.files[0].name;
        $('input:text', $(e.target).parent()).val(name);
      });

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
      $("input[name='phone']").keyup(function() {
          $(this).val($(this).val().replace(/^(\d{2})(\d{4})(\d)+$/, "($1)$2-$3"));
      });
      
      $('.message .close').on('click', function() {
          $(this).closest('.message').transition('fade');
      });

      function resizeGraphs() {
          var salesChart = $("#sales_chart");
          var table = $("<div class='ui'></div>.table");
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
});