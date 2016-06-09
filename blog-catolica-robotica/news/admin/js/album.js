$(document).ready(function(){
    
    var confirmDelete = 0;
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
    
    $('.updateAlbumName').live('click',function(){
        var album_id = $('.album_name').attr('id');
        var album_name = $.trim( $('.album_name').val() );        
        var album_local = $.trim( $('#album_local').val() );        
        var album_data = $.trim( $('#album_data').val() );        
		var album_desc = $.trim( $('#album_desc').val() );        
        $.post('actions.php?action=updateAlbumName',
        {
            album_name:album_name,
            album_data:album_data,
            album_local:album_local,
            album_id:album_id,
			album_desc:album_desc
        },
        function(data){
            notify('<h1>'+data+'</h1>');
        })
        
        $('.refresh').click();
    })
    
    
    $('.refresh').live('click',function(){
        
        var foto_id  = "f_" + $(this).attr('id') ;
        var foto_caption = $("#"+foto_id).val();
        var foto_info = $("#i"+foto_id).val();
        $.post('actions.php?action=updateFotoName',
        {
            foto_caption:foto_caption,
            foto_info:foto_info,
            foto_id:foto_id
        },
        function(data){
            if(data != 1)
            {
                notify('<h1>'+data+'</h1>');
            }
        //$('#'+foto_id).attr('title',$('#'+foto_id).val());
        //$('#'+foto_id).hideTip();
        //$('#'+foto_id).showTip();
        //$('#'+foto_id).refreshTip();
        })
        
    })
    
    $('.cover').live('click',function(){
        var foto_id = $(this).attr('id');
        var foto_album = $(this).attr('album');
        
        $.post('actions.php?action=updateFotoCover',
        {
            foto_album:foto_album,
            foto_id:foto_id
        },
        function(data){
            notify('<h1>'+data+'</h1>');
        })
    })
    
    $('.deleteAlbum').live('click',function(){
        var id = $(this).attr('id');
        var msg  = '<ul class="dialog_delete">';
        msg += '<br><h1>Você está prestes a remover um álbum e suas fotos!</h1>';
        msg += '<br><p>Deseja realmente prosseguir?</p>';
        msg += '</ul>'
        $('body').append('<div id="dialog"  class="dialogr" title="Remover Álbum">'+msg+'</div>');
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
                    window.location = 'album.php?delete='+id;
                }		
            }
        })
        return false;
    })
    
    
    /*Sorter Foto*/
    $( ".sortable" ).sortable({
        cursor: 'crosshair',
        helper: "clone",
        opacity: 0.6,
        update:function(event, ui){
            var order = $(this).sortable('serialize')
            var url = "actions.php?action=updateVideoPos"
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
    
    /*Sorter Album*/
    $( ".sortableAlbum" ).sortable({
        cursor: 'crosshair',
        helper: "clone",
        opacity: 0.6,
        update:function(event, ui){
            var order = $(this).sortable('serialize')
            var url = "actions.php?action=updateAlbumPos"
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
            
    $('.delete').live('click',function(){
        var foto_id = $(this).attr('id');
        
        if(confirmDelete  != 1)
        {
            var msg  = '<ul class="dialog_delete">';
            msg += '<br><h1>Você está prestes a remover uma foto!</h1>';
            msg += '<br><p>Deseja realmente prosseguir?</p>';
            msg += '</ul>'
            $('body').append('<div id="dialog"  class="dialogr" title="Remover Foto">'+msg+'</div>');
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
                        $.post('actions.php?action=deleteFoto',
                        {
                            foto_id:foto_id
                        },
                        function(data){
                            $('#item_'+foto_id).remove();
                            notify('<h1>'+data+'</h1>');
                            $(this).dialog("close");
                            $("#dialog").remove();                        
                            if(confirmDelete == 0)
                            {
                                var msg  = '<ul class="dialog_delete">';
                                msg += '<br><p>Deseja exibir a confirmação de exclusão na próxima <br> foto que remover deste álbum?</p>';
                                msg += '</ul>'
                                $('body').append('<div id="dialog"  class="dialogr" title="Confirmação de Exclusão">'+msg+'</div>');
                                $( "#dialog" ).dialog({
                                    modal: true,
                                    open: function(event, ui) { 
                                        $(this).parent().children().children('.ui-dialog-titlebar-close').hide();
                                    },	 	    
                                    width: 420,
                                    height: 160,
                                    buttons: {
                                        "Não": function() {
                                            confirmDelete = 1;
                                            $(this).dialog("close");
                                            $("#dialog").remove();
                                        },
                                        "Sim": function() {
                                            confirmDelete = 2;
                                            $(this).dialog("close");
                                            $("#dialog").remove();
                                        }		
                                    }
                                }) 
                            }
    
                        })
                    }		
                }
            })
        }
        else
        {
            $.post('actions.php?action=deleteFoto',
            {
                foto_id:foto_id
            },
            function(data){
                $('#item_'+foto_id).remove();
                notify('<h1>'+data+'</h1>');
                $(this).dialog("close");
                $("#dialog").remove();                        
            })                
        }
    })
    
    
})

function confirmOnOff()
{
    var msg  = '<ul class="dialog_delete">';
    msg += '<br><h1>Confirmação de exclusão de fotos!</h1>';
    msg += '<br><p>Deseja exibir a confirmação de exclusão na <br>próxima foto que quiser remover deste álbum?</p>';
    msg += '</ul>'
    $('body').append('<div id="dialog"  class="dialogr" title="Confirmação de Exclusão">'+msg+'</div>');
    $( "#dialog" ).dialog({
        modal: true,
        open: function(event, ui) { 
            $(this).parent().children().children('.ui-dialog-titlebar-close').hide();
        },	 	    
        width: 400,
        height: 180,
        buttons: {
            "Não": function() {
                confirmDelete = true;
                $(this).dialog("close");
                $("#dialog").remove();
            },
            "Sim": function() {
                confirmDelete = false;
                $(this).dialog("close");
                $("#dialog").remove();
            }		
        }
    })    
}