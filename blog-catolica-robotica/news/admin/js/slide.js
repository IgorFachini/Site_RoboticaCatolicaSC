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
    
    $('.updateBannerLink').live('click',function(){
        var banner_id = $('.banner_link').attr('id');
        var banner_link = $.trim( $('.banner_link').val() );        
        $.post('actions.php?action=updateBannerLink',
        {
            banner_link:banner_lini,
            banner_id:banner_id
        },
        function(data){
            notify('<h1>'+data+'</h1>');
        })        
    })
    
    $('.deleteBanner').live('click',function(){
        var id = $(this).attr('id');
        var msg  = '<ul class="dialog_delete">';
        msg += '<br><h1>Você está prestes a remover um banner!</h1>';
        msg += '<br><p>Deseja realmente prosseguir?</p>';
        msg += '</ul>'
        $('body').append('<div id="dialog"  class="dialogr" title="Remover Banner">'+msg+'</div>');
        $( "#dialog" ).dialog({
            modal: true,
            open: function(event, ui) { 
                $(this).parent().children().children('.ui-dialog-titlebar-close').hide();
            },	 	    
            width: 420,
            height: 160,
            buttons: {
                "Cancelar": function() {
                    $(this).dialog("close");
                    $("#dialog").remove();
                },
                "Prosseguir": function() {
                    window.location = 'slide.php?delete='+id;
                }		
            }
        })
        return false;
    })
    
    /*Sorter Album*/
    $( ".sortableBanner" ).sortable({
        cursor: 'crosshair',
        helper: "clone",
        opacity: 0.6,
        update:function(event, ui){
            var order = $(this).sortable('serialize')
            var url = "actions.php?action=updateBannerPos"
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

function validaUp() {
    if($('#banner_url').val() == '')
    {
        notify('<h1>Selecione uma imagem</h1>');
        return false;
    }
}