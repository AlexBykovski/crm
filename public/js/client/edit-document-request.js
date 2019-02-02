$(document).ready(function(){
    const BUDGET = {
        "3 месяца" : "2000",
        "6 месяцев" : "2500",
        "год" : "3000",
        "3 года" : "4000",
    };

    const DATE_END_ADD = {
        "3 месяца" : {months: 3},
        "6 месяцев" : {months: 6},
        "год" : {years: 1},
        "3 года" : {years: 3},
    };

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
                    modal.modal("show");

                    listenChangeBackDatingAndTerm();
                }
            })
            .fail(function(response) {
                console.error(response);
            });
    }

    function listenChangeBackDatingAndTerm() {
        //2019-02-03
        let registerFrom = $("#document_request_form_registerFrom");
        let registerTo = $("#document_request_form_registerTo");

        $("#document_request_form_isBackDating").change(function(ev){
            let isChecked = $(this).is(":checked");

            registerFrom.attr("readonly", !isChecked);
            registerTo.attr("readonly", !isChecked);
        });

        $("#document_request_form_term").change(function(ev){
            let value = $(this).val();

            if(!BUDGET.hasOwnProperty(value)){
                return false;
            }

            let term = BUDGET[value];

            $("#document_request_form_budget").val(term);
            registerTo.val(moment(registerFrom.val()).add(DATE_END_ADD[value]).format("YYYY-MM-DD"));
        });
    }
});