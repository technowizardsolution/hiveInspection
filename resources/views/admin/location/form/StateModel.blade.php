<div class="modal fade" id="stateModal" role="dialog" aria-labelledby="stateModalLabel">
            <div class="modal-dialog  " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="stateModalLabel">New State </h4>
                    </div>

                    <div class="modal-body">
                        <form class="form-horizontal" id="stateForm" role="form" action="{{url('admin/state')}}" method="post">
                            @csrf
                            <div class="form-group {{ $errors->has('state_country') ? ' has-error' : '' }}">
                                <label  class="col-sm-4 control-label" for="state_country">Country <span class="colorRed"> *</span></label>
                                <div class="col-sm-8">
                                    @if(count($countries)!=1)
                                    <select name="state_country" id="state_country" class="form-control">
                                        <option></option>
                                         @foreach ($countries as $country)
                                         <option value="{{ $country->country_id }}">{{ $country->name }}</option>
                                         @endforeach
                                    </select>
                                    @else
                                        <select disabled name="state_country" id="state_country" class="form-control">
                                             <option value="{{ $countries[0]->country_id }}">{{ $countries[0]->name }}</option>
                                        </select>
                                        <input type="hidden" name ="state_country" value="{{ $countries[0]->country_id }}"/>
                                    @endif

                                    <div class="country-error"></div>
                                    @if ($errors->has('state_country'))
                                    <span class="help-block alert alert-danger">
                                        <strong>{{ $errors->first('state_country') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('state_name') ? ' has-error' : '' }}">
                                <label  class="col-sm-4 control-label" for="state_name">State Name <span class="colorRed"> *</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="state_name" name="state_name" placeholder="State Name" value="{{old('state_name')}}"/>
                                    @if ($errors->has('state_name'))
                                    <span class="help-block alert alert-danger">
                                        <strong>{{ $errors->first('state_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <span class="help-block"> <span class="colorRed"> *</span> mentioned fields are mandatory.</span>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" id="stateCreateBtn" class="btn btn-info pull-right">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>