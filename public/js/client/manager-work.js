$(document).ready(function(){
    $("#work-manager").click(function(){
        if(!!$(this).find("i").attr("data-is-active")){
            return false;
        }

        $.ajax( {
            type: "POST",
            url: $(this).attr("data-href"),
        } )
            .done(function(response) {
                if(response && response.success){
                    return window.location.href = window.location.pathname;
                }

                if(response && response.message){
                    alert(response.message);
                }
            })
            .fail(function(response) {
                console.error(response);
            });
    });
});