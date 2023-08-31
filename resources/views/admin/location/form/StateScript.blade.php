<script type="text/javascript">
	 $(document).ready(function() {
	 	
           $("#state_country").select2({
                placeholder: "Select a Country",
                allowClear: true,
            });
            
        });
	 $(document.body).on('click', "#stateCreateBtn", function(){
            if ($("#stateForm").length){
                $("#stateForm").validate({
                    errorElement: 'span',
                    errorClass: 'text-red',
                    ignore: [],
                    rules: {
                        "state_country":{
                            required:true,
                        },
                        "state_name":{
                            required:true,
                            minlength: 2,
                            maxlength: 20
                        }
                    },
                    messages: {
                        "state_country":{
                            required:"Select country",
                        },
                        "state_name":{
                            required:"Enter State name",
                        }
                    },
                    errorPlacement: function(error, element) {
                        if(element.attr("name") == 'state_country'){
                            element.closest('.form-group ').find(".country-error").html(error);
                        } else {
                            error.insertAfter(element.closest(".form-control"));
                        }
                    },
                });
            }
        });
</script>