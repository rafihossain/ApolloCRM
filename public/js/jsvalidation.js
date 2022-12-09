$().ready(function () {

    // var mySelect2 = $('#masterCategory')
    // mySelect2.select2();
    // //global var for select 2 label
    // var select2label

    $("#partnerAdd").validate({
        // in 'rules' user have to specify all the constraints for respective fields
        rules: {
            master_category_id: "required", 
            partner_type: "required",
            name: "required",
            workflow_id: "required", 
            currency_id: "required", 
            email: "required", 
            
            master_category_id: {
                required: true,
            },
            partner_type: {
                required: true, 
            },
            name: {
                required: true,
            },
            workflow_id: {
                required: true, 
            },
            currency_id: {
                required: true,
            },    
            email: {
                required: true,
            },    
        },
        // in 'messages' user have to specify message as per rules
        messages: {
            master_category_id: "Master category field is required.", 
            partner_type: "Partner type field is required.",
            name: "Partner name field is required.",
            workflow_id: "Service workflow field is required.", 
            currency_id: "Currency field is required.", 
            email: "Email field is required.", 
        },
        // errorPlacement: function(label, element) {
        //     // console.log(label);

        //     if (element.hasClass('web-select2')) {
        //     label.insertAfter(element.next('.select2-container')).addClass('mt-2 text-danger');
        //     select2label = label
        //     } else {
        //     label.addClass('mt-2 text-danger');
        //     label.insertAfter(element);
        //     }
        // },
        // highlight: function(element) {
        //     $(element).parent().addClass('is-invalid')
        //     $(element).addClass('form-control-danger')
        // },
        // success: function(label, element) {
        //     $(element).parent().removeClass('is-invalid')
        //     $(element).removeClass('form-control-danger')
        //     label.remove();
        // },
        // submitHandler: function(form) {

        // },
    });

    //watch the change on select
    // mySelect2.on("change", function(e) {
    //     select2label.remove(); //remove label
    // });

});