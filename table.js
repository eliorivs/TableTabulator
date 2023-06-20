var table;

function ObtainTags()
    {
        var items = $.ajax(
        {
            async: false,
            url: "data/header.php",
            type: "POST",
           
            dataType: "JSON"
        }).responseJSON;
        return items;
    }
    var head = ObtainTags();
    console.log(head);

    function customTranslations() {
  return {
    // Definir las traducciones personalizadas aquí
    pagination: {
      nextPage: "Siguiente",
      lastPage: "Último"
    }
  };
}





    function inicializarTabla(head)
    {
        table = new Tabulator("#example-table", {
            height:"411px",
            layout:"fitColumns",           
            progressiveLoad:"scroll",
            paginationSize:20,
            placeholder:"No Data Set",
            paginationCounter:"rows",
            columns: head, 
            locale: "es",
            pagination:{
                nextPage:"next",
                next:"Next"
            } ,  
            langs: {
                'es': customTranslations // Utilizar la función de traducción personalizada para el idioma español
              }       
        });
    } 

    inicializarTabla(head);


    function Actualizartabla()
    {  
        table.clearData();
        //table.setOption("placeholder", "Cargando...");
        
        $.ajax({
            url:"data/load_data.php",
            data: {
                param1: "valor1",
                param2: "valor2",
               
            },
            dataType: "JSON",
            success: function(response){
                console.log(response);
       
                table.addData(response.data, true);
             
            }
        });
       

    }


$("#actualizar-btn").on("click", function() {

    Actualizartabla();
   
});