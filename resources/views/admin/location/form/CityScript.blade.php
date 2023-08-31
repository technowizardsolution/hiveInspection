<script type="text/javascript">
     $(document).ready(function() {
           $("#city_country").select2({
                placeholder: "Select a Country",
                allowClear: true,
            });

            $("#city_state").select2({
                placeholder: "Select a State",
                allowClear: true,
            });
        });
     
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
 $('#city_country').on('change', function(){

            var id = $('#city_country').val();
            $.ajax({
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: SITE_URL+'/getState',
                data: {
                    id
                },
                success: function(data) {
                    $('#city_state').html(data);
                }
            });
        });
</script>