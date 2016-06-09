$(document).ready(function(){

    $('.deleteCategoria').live('click',function(){
        var id = $(this).attr('id');
        var msg  = '<ul class="dialog_delete">';
        msg += '<br><h1>Você está prestes a remover uma categoria<br /> com todos os álbuns e fotos nela contida!</h1>';
        msg += '<br><p>Deseja realmente prosseguir?</p>';
        msg += '</ul>'
        $('body').append('<div id="dialog"  class="dialogr" title="Remover Categoria">'+msg+'</div>');
        $( "#dialog" ).dialog({
            modal: true,
            open: function(event, ui) { 
                $(this).parent().children().children('.ui-dialog-titlebar-close').hide();
            },	 	    
            width: 350,
            height: 190,
            buttons: {
                "Cancelar": function() {
                    $(this).dialog("close");
                    $("#dialog").remove();
                },
                "Prosseguir": function() {
                    window.location = 'categoria.php?delete='+id;
                }		
            }
        })
        return false;
    })
    
    /*Sorter Categoria*/
    $( ".sortableCat" ).sortable({
        cursor: 'crosshair',
        helper: "clone",
        opacity: 0.6,
        update:function(event, ui){
            var order = $(this).sortable('serialize')
            var url = "actions.php?action=updateCatPos"
            $.post(url,{
                item: order
            },function(data){
                var arr = Array;
                arr = ["Muito bom!", "Demais!", "Ficou legal!", "Super!", "Agora está bonito!","Contiue assim!"];
                msg  = arr[Math.floor(Math.random()*arr.length)];
                notify('<h1>Posição Atualizada<br> '+msg+'</h1>');
            })
        }
    })
    $( ".drag" ).disableSelection();    
})