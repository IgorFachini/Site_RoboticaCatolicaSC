$(document).ready(function(){
    
    $('#toUp').live('click',function(){
        $.scrollTo( $('#status-bar') , 1000);
    });
    $('#toDown').live('click',function(){
        $.scrollTo( $('#footer') , 1000);
    });
    $('#toBack').live('click',function(){
        window.location = $(this).attr('url');
    });   
    $('#toUpdate').live('click',function(){
        $('#f-update').submit()
    });  
    
    $('.deleteNoticia').live('click',function(){
        var id = $(this).attr('id');
        var msg  = '<ul class="dialog_delete">';
        msg += '<br><h1>Você está prestes a remover uma notícia!</h1>';
        msg += '<br><p>Deseja realmente prosseguir?</p>';
        msg += '</ul>'
        $('body').append('<div id="dialog"  class="dialogr" title="Remover Notícia">'+msg+'</div>');
        $( "#dialog" ).dialog({
            modal: true,
            open: function(event, ui) { 
                $(this).parent().children().children('.ui-dialog-titlebar-close').hide();
            },	 	    
            width: 420,
            height: 180,
            buttons: {
                "Cancelar": function() {
                    $(this).dialog("close");
                    $("#dialog").remove();
                },
                "Prosseguir": function() {
                    window.location = 'noticia.php?delete='+id;
                }		
            }
        })
        return false;
    })
    
    
})

function validaUp() {
    if($('#noticia_foto').val() == '')
    {
        notify('<h1>Selecione uma imagem</h1>');
        return false;
    }
}