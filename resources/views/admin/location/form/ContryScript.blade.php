<script type="text/javascript">
	
	 $(document.body).on('click', "#cityCreateBtn", function(){
            if ($("#cityForm").length){
                $("#cityForm").validate({
                    errorElement: 'span',
                    errorClass: 'text-red',
                    ignore: [],
                    rules: {
                        "city_country":{
                            required:true,
                        },
                        "city_state":{
                            required:true,
                        },
                        "city_name":{
                            required:true,
                            minlength: 2,
                            maxlength: 20
                        }
                    },
                    messages: {
                        "city_country":{
                            required:"Select Country",
                        },
                        "city_state":{
                            required:"Select state",
                        },
                        "city_name":{
                            required:"Enter City name",
                        }
                    },
                    errorPlacement: function(error, element) {
                        if(element.attr("name") == 'city_country'){
                            element.closest('.form-group ').find(".country-error").html(error);
                        } else if(element.attr("name") == 'city_state'){
                            element.closest('.form-group ').find(".state-error").html(error);
                        } else {
                            error.insertAfter(element.closest(".form-control"));
                        }
                    },
                });
            }
        });

	  $(document.body).on('click', "#countryCreateBtn", function(){
            if ($("#countryForm").length){
                $("#countryForm").validate({
                    errorElement: 'span',
                    errorClass: 'text-red',
                    ignore: [],
                    rules: {
                        "short_code":{
                            required:true,
                            minlength: 2,
                            maxlength: 20
                        },
                        "country_name":{
                            required:true,
                            minlength: 2,
                            maxlength: 20
                        },
                        "phonecode":{
                            required:true,
                            number:true,
                            min:1,
                            minlength:1,
                            maxlength:5
                        },
                    },
                    messages: {
                        "short_code":{
                            required:"Enter Short code",
                        },
                        "country_name":{
                            required:"Enter Country Name",
                        },
                        "phonecode":{
                            required:"Enter Phonecode",
                        },
                    },
                    errorPlacement: function(error, element) {
                        error.insertAfter(element.closest(".form-control"));
                    },
                });
            }
        });

</script>