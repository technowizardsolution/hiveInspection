
  <div class="modal fade" id="countryModal" role="dialog" aria-labelledby="countryModalLabel">
            <div class="modal-dialog  " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="countryModalLabel">New Country</h4>
                    </div>

                    <div class="modal-body">
                        <form class="form-horizontal" id="countryForm" role="form" action="{{url('admin/countries')}}" method="post" enctype="multipart/form-data" >
                            @csrf
                            <div class="form-group {{ $errors->has('short_code') ? ' has-error' : '' }}">
                                <label  class="col-sm-4 control-label" for="short_code">Short Code <span class="colorRed"> *</span></label>
                                <div class="col-sm-8 jointbox">
                                    <input type="type" class="form-control" name="short_code" maxlength="2" placeholder="Short Code" value="{{old('short_code')}}"/>
                                    @if ($errors->has('short_code'))
                                    <span class="help-block alert alert-danger">
                                        <strong>{{ $errors->first('short_code') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('country_name') ? ' has-error' : '' }}">
                                <label  class="col-sm-4 control-label" for="country_name" >Country Name <span class="colorRed"> *</span></label>
                                <div class="col-sm-8 jointbox">
                                    <input type="type" class="form-control" name="country_name" placeholder="Country Name" value="{{old('country_name')}}"/>
                                    @if ($errors->has('country_name'))
                                    <span class="help-block alert alert-danger">
                                        <strong>{{ $errors->first('country_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('phonecode') ? ' has-error' : '' }}">
                                <label  class="col-sm-4 control-label" for="phonecode">Phonecode<span class="colorRed"> *</span></label>
                                <div class="col-sm-8 jointbox">
                                    <input type="number" class="form-control" placeholder="Phonecode" name="phonecode" max="500000" value="{{old('phonecode')}}"/>
                                    @if ($errors->has('phonecode'))
                                    <span class="help-block alert alert-danger">
                                        <strong>{{ $errors->first('phonecode') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <span class="help-block"> <span class="colorRed"> *</span> mentioned fields are mandatory.</span>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" id="countryCreateBtn" class="btn btn-info pull-right">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@section('innerscript')
<script type="text/javascript">
    alert(1);
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
@endsection

