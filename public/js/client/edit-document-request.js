$(document).ready(function(){
    const BUDGET = {
        "3 месяца" : "2000",
        "1 год" : "2500",
        "3 года" : "3500",
        "5 лет" : "4500"
    };

    const DATE_END_ADD = {
        "3 месяца" : {months: 3},
        "1 год" : {years: 1},
        "3 года" : {years: 3},
        "5 лет" : {years: 5},
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
                    return $("#form-filter-search").find("button[type=submit]").click();
                }

                modal.find(".modal-content").html(response);

                addAutocomplete();

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

    function addAutocomplete(){
        $.getJSON( "/json/department-addresses.json", function(json){
            setAutocomplete(json, 'street');
            setAutocomplete(json, 'district');
            setAutocomplete(json, 'fio');
            setAutocomplete(json, 'department');
            setAutocomplete(json, 'house');
            setAutocomplete(json, 'apartment');
            setAutocomplete(json, 'region');
            setAutocomplete(json, 'subway');
        });
    }

    function setAutocomplete(addressesAutocomplete, type) {
        $( ".document-address-" + type ).autocomplete({
            minLength: 1,
            source: [],
            focus: function( event, ui ) {
                return false;
            },
            select: function( event, ui ) {
                $( ".document-address-street" ).val( ui.item.street );
                $( ".document-address-district" ).val( ui.item.district );
                $( ".document-address-fio" ).val( ui.item.fio );
                $( ".document-address-department" ).val( ui.item.department );
                $( ".document-address-house" ).val( ui.item.house );
                $( ".document-address-apartment" ).val( ui.item.apartment );
                $( ".document-address-region" ).val( ui.item.region );
                $( ".document-address-subway" ).val( ui.item.subway );

                return false;
            },
            appendTo: "#document-address-" + type + "-container",
            search: function () {
                $(this).autocomplete( 'option', 'source', $.map(addressesAutocomplete, function (value, key) {
                    value["value"] = value[type];

                    return value;
                }) );
            }
        })
            .autocomplete( "instance" )._renderItem = function( ul, item ) {
            return $( "<li>" )
                .append( "<div>" + item[type] + "</div>" )
                .appendTo( ul );
        };
    }

    $("body").on("click", ".only-one-checkbox", function (ev) {
        $(".only-one-checkbox").not(ev.target).prop("checked", !$(ev.target).is(":checked"));
    });
});