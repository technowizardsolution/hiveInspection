<div class="modal fade" id="cityModal" role="dialog" aria-labelledby="cityModalLabel">
            <div class="modal-dialog  " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="cityModalLabel">New City</h4>
                    </div>

                    <div class="modal-body">
                        <form class="form-horizontal" id="cityForm" role="form" action="{{url('admin/city')}}" method="post">
                            @csrf
                            <div class="form-group {{ $errors->has('city_country') ? ' has-error' : '' }}">
                                <label  class="col-sm-4 control-label" for="city_country">Country <span class="colorRed"> *</span></label>
                                <div class="col-sm-8">
                                 @if(isset($countries))
                                    <select name="city_country" id="city_country" class="form-control">
                                        <option></option>
                                    @foreach ($countries as $country)
                                    <option value="{{ $country->country_id }}">{{ $country->name }}</option>
                                    @endforeach
                                    </select>
                                @else
                                    <select disabled name="city_country" id="city_country" class="form-control">
                                         <option value="{{ $state[0]->country_id }}">{{ $state[0]->country_name }}</option>
                                    </select>
                                    <input type="hidden" name ="city_country" value="{{ $state[0]->country_id }}"/>
                                @endif
                                    <div class="country-error"></div>
                                    @if ($errors->has('city_country'))
                                    <span class="help-block alert alert-danger">
                                        <strong>{{ $errors->first('city_country') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('city_state') ? ' has-error' : '' }}">
                                <label  class="col-sm-4 control-label" for="city_state">State <span class="colorRed"> *</span></label>
                                <div class="col-sm-8">
                                     @if(isset($state) && count($state)==1)
                                     <select name="city_state" id="city_state" class="form-control" disabled>
                                    <option value="{{ $state[0]->state_id }}">{{ $state[0]->name }}</option>
                                    </select>
                                    <input type="hidden" name ="city_state" value="{{ $state[0]->state_id }}"/>

                                       @else
                                    <select name="city_state" id="city_state" class="form-control"></select>
                                     @endif
                                    <div class="state-error"></div>
                                    @if ($errors->has('city_state'))
                                    <span class="help-block alert alert-danger">
                                        <strong>{{ $errors->first('city_state') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('city_name') ? ' has-error' : '' }}">
                                <label  class="col-sm-4 control-label" for="city_name">City <span class="colorRed"> *</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="city_name" name="city_name" placeholder="City Name" value="{{old('city_name')}}"/>
                                    @if ($errors->has('city_name'))
                                        <span class="help-block alert alert-danger">
                                            <strong>{{ $errors->first('city_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <span class="help-block"> <span class="colorRed"> *</span> mentioned fields are mandatory.</span>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" id="cityCreateBtn" class="btn btn-info pull-right">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>