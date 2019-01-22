$(document).ready(function(){
    let modal = $("#centralModalLGRequestMain");

    $(".link-to-edit-document-request").click(function(){
        let id = $(this).data("id");
        let urlEdit = "/request/edit-document-request/" + id;
        editRequest({url: urlEdit});

        $("body").on("click", "#edit-document-request-form-button", function(){
            if($(this)[0].hasAttribute("disabled")){
                return false;
            }

            let data = $("#edit-document-request-form").serialize();
            $("#edit-document-request-form-button").attr("disabled", "");

            editRequest({
                type: "POST",
                url: urlEdit,
                data: data,
                headers: {
                    "Content-Type": 'application/x-www-form-urlencoded;charset=utf-8'
                },
            });
        })

    });

    function editRequest(parameters) {
        $.ajax( parameters )
            .done(function(response) {
                if(response && response.success && response.redirectUrl){
                    return window.location.href = response.redirectUrl;
                }

                modal.find(".modal-content").html(response);

                if(!modal.is(':visible')){
                    modal.modal("show")
                }
            })
            .fail(function(response) {
                console.error(response);
            });
    }
});