@extends('user.layouts.authapp')
@section('title') Hive | @endsection
@section('content')
<style>
  

    .tab{display: none; width: 100%; height: 50%;margin: 0px auto;}
.current{display: block;}

.previous {background-color: #bbbbbb; }

/* Make circles that indicate the steps of the form: */
.step {height: 30px; width: 30px; cursor: pointer; margin: 0 2px; color: #fff; background-color: #bbbbbb; border: none; border-radius: 50%; display: inline-block; opacity: 0.8; padding: 5px}

.step.active {opacity: 1; background-color: #69c769;}

.step.finish {background-color: #4CAF50; }

.error {color: #f00; }
</style>

<section class="form-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <a href="{{url('/user/inspection/export')}}" class="float-right; margin-left: 8px;">
                        <button type="button" class="btn btn-primary waves-effect waves-float waves-light">Export</button>
                    </a>


                    <form class="form-horizontal" id="inspectionForm" role="form" action="{{url('user/inspection/store')}}" method="post" enctype="multipart/form-data" >
                        @csrf 
                        <input type="hidden" class="form-control" name="hive_id" id="hive_id" value="{{$hive_id}}">
                        <div class="step-info-card step1 tab">
                            <div class="step-info">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-title">
                                            <h3>Inspection Step 1</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group {{ $errors->has('inspection_date') ? ' has-error' : '' }}">
                                            <label for="">Date</label>
                                            <input type="date" class="form-control" name="inspection_date" id="inspection_date" placeholder="select your date">
                                            @if ($errors->has('inspection_date'))
                                            <span class="help-block alert alert-danger">
                                                <strong>{{ $errors->first('inspection_date') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="checkbox-card">
                                            <div class="form-group">
                                                <label class="checkbox-label">Normal Hive Condition
                                                    <input type="checkbox" name="normal_hive_condition" id="normal_hive_condition" value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="checkbox-label">Saw Queen
                                                    <input type="checkbox" name="saw_queen" id="saw_queen" value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div><div class="form-group">
                                                <label class="checkbox-label">Queen Marked
                                                    <input type="checkbox" name="queen_marked" id="queen_marked" value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="checkbox-label">Eggs Queen
                                                    <input type="checkbox" name="eggs_seen" id="eggs_seen" value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="checkbox-label">Larva Queen
                                                    <input type="checkbox" name="larva_seen" id="larva_seen" value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="checkbox-label">Pupa Queen
                                                    <input type="checkbox" name="pupa_seen" id="pupa_seen" value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="checkbox-label">Drone Queen
                                                    <input type="checkbox" name="drone_cells" id="drone_cells" value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="checkbox-label">Queen cells
                                                    <input type="checkbox" name="queen_cells" id="queen_cells" value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="checkbox-label">Hive Beetles
                                                    <input type="checkbox" name="hive_beetles" id="hive_beetles" value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="checkbox-label">Wax Moth
                                                    <input type="checkbox" name="wax_moth" id="wax_moth" value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="checkbox-label">Noseema
                                                    <input type="checkbox" name="noseema" id="noseema" value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="checkbox-label">Mite Wash
                                                    <input type="checkbox" name="mite_wash" id="mite_wash" value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label for="Mite Count">Mite Count
                                                    <input type="text" name="mite_count" class="form-control" id="mite_count" placeholder="Mite Count">                                                   
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>                            
                            <img src="{{ URL::asset('public/images/shap.png')}}" alt="">
                        </div> 

                        <div class="step-info-card step2 tab">
                            <div class="step-info">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-title">
                                            <h3>Inspection Step 2</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="Temperment">Temperment</label>
                                            <select name="temperment" id="temperment" class="form-control">
                                                <option value="">Select Temperment</option>
                                                <option value="Calm">Calm</option>
                                                <option value="Nervous">Nervous</option>
                                                <option value="Aggressive">Aggressive</option>                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="Population">Population</label>
                                            <select name="population" id="population" class="form-control">
                                                <option value="">Select Population</option>
                                                <option value="Heavy">Heavy</option>
                                                <option value="Moderate">Moderate</option>
                                                <option value="Low">Low</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        Laying Pattern
                                        <div class="checkbox-card">
                                            <div class="form-group">
                                                <label class="checkbox-label">Solid & Uniform frames
                                                    <input type="checkbox" name="solid_uniform_frames" id="solid_uniform_frames" value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <input type="text" class="form-control mt-3 hide solid_uniform_frames_input" name="solid_uniform_frames_input" placeholder="Solid & Uniform frames value">
                                            </div>
                                            <div class="form-group">
                                                <label class="checkbox-label">Slightly Spotty frames
                                                <input type="checkbox" name="slightly_spotty_frames" id="slightly_spotty_frames" value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <input type="text" class="form-control mt-3 hide slightly_spotty_frames_input" name="slightly_spotty_frames_input" placeholder="Slightly Spotty frames value">
                                            </div>
                                            <div class="form-group">
                                                <label class="checkbox-label">Spotty frames
                                                <input type="checkbox" name="spotty_frames" id="spotty_frames" value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="checkbox-label">Normal Odor
                                                    <input type="checkbox" name="normal_odor" id="normal_odor" value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Brood</label>
                                            <select name="brood" id="brood" class="form-control">
                                                <option value="">Select Brood</option>
                                                <option value="Heavy">Heavy</option>
                                                <option value="Moderate">Moderate</option>
                                                <option value="Low">Low</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Honey</label>
                                            <select name="honey" id="honey" class="form-control">
                                                <option value="">Select Honey</option>
                                                <option value="Heavy">Heavy</option>
                                                <option value="Moderate">Moderate</option>
                                                <option value="Low">Low</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Pollen</label>
                                            <select name="pollen" id="pollen" class="form-control">
                                                <option value="">Select Pollen</option>
                                                <option value="Heavy">Heavy</option>
                                                <option value="Moderate">Moderate</option>
                                                <option value="Low">Low</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                            <img src="{{ URL::asset('public/images/shap.png')}}" alt="">
                        </div>

                        <div class="step-info-card step3 tab">
                            <div class="step-info">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-title">
                                            <h3>Inspection Step 3</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group {{ $errors->has('frames_of_bees') ? ' has-error' : '' }}">
                                            <label for="">Frames of Bees</label>
                                            <input type="text" class="form-control" name="frames_of_bees" id="frames_of_bees" placeholder="Frames of Bees">
                                            @if ($errors->has('frames_of_bees'))
                                            <span class="help-block alert alert-danger">
                                                <strong>{{ $errors->first('frames_of_bees') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group {{ $errors->has('frames_of_brood') ? ' has-error' : '' }}">
                                            <label for="">Frames of Brood</label>
                                            <input type="text" class="form-control" name="frames_of_brood" id="frames_of_brood" placeholder="Frames of Brood">
                                            @if ($errors->has('frames_of_brood'))
                                            <span class="help-block alert alert-danger">
                                                <strong>{{ $errors->first('frames_of_brood') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group {{ $errors->has('frames_of_honey') ? ' has-error' : '' }}">
                                            <label for="">Frames of Honey</label>
                                            <input type="text" class="form-control" name="frames_of_honey" id="frames_of_honey" placeholder="Frames of Honey">
                                            @if ($errors->has('frames_of_honey'))
                                            <span class="help-block alert alert-danger">
                                                <strong>{{ $errors->first('frames_of_honey') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group {{ $errors->has('frames_of_pollen') ? ' has-error' : '' }}">
                                            <label for="">Frames of Pollen</label>
                                            <input type="text" class="form-control" name="frames_of_pollen" id="frames_of_pollen" placeholder="Frames of Pollen">
                                            @if ($errors->has('frames_of_pollen'))
                                            <span class="help-block alert alert-danger">
                                                <strong>{{ $errors->first('frames_of_pollen') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="checkbox-card">
                                            <div class="form-group">
                                                <label class="checkbox-label">Honey Supers
                                                    <input type="checkbox" name="honey_supers" id="honey_supers" value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <input type="text" class="form-control mt-3 hide honey_supers_input" name="honey_supers_input" placeholder="Honey Supers value">
                                            </div>
                                            <div class="form-group">
                                                <label class="checkbox-label">Add Supers
                                                    <input type="checkbox" name="add_supers" id="add_supers" value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <input type="text" class="form-control mt-3 hide add_supers_input" name="add_supers_input" placeholder="Add Supers value">
                                            </div>
                                            <div class="form-group">
                                                <label class="checkbox-label">Weigh Super 3
                                                    <input type="checkbox" name="weigh_super_3" id="weigh_super_3" value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <input type="text" class="form-control mt-3 hide weigh_super_3_input" name="weigh_super_3_input" placeholder="Weigh Super 3 value">
                                            </div>
                                            <div class="form-group">
                                                <label class="checkbox-label">Weigh Super 2
                                                    <input type="checkbox" name="weigh_super_2" id="weigh_super_2" value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <input type="text" class="form-control mt-3 hide weigh_super_2_input" name="weigh_super_2_input" placeholder="Weigh super 2 value">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="checkbox-card">
                                            <div class="form-group">
                                                <label class="checkbox-label">Weigh super 1
                                                    <input type="checkbox" name="weigh_super_1" id="weigh_super_1" value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <input type="text" class="form-control mt-3 hide weigh_super_1_input" name="weigh_super_1_input" placeholder="Weigh super 1 value">
                                            </div>
                                            <div class="form-group">
                                                <label class="checkbox-label">Weigh brood 3 value
                                                    <input type="checkbox" name="weigh_brood_3" id="weigh_brood_3" value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <input type="text" class="form-control mt-3 hide weigh_brood_3_input" name="weigh_brood_3_input" placeholder="Weigh brood 3 value">
                                            </div>
                                            <div class="form-group">
                                                <label class="checkbox-label">Weigh brood 2 value
                                                    <input type="checkbox" name="weigh_brood_2" id="weigh_brood_2" value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <input type="text" class="form-control mt-3 hide weigh_brood_2_input" name="weigh_brood_2_input" placeholder="Weigh brood 2 value">
                                            </div>
                                            <div class="form-group">
                                                <label class="checkbox-label">Weigh brood 1 value
                                                    <input type="checkbox" name="weigh_brood_1" id="weigh_brood_1" value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <input type="text" class="form-control mt-3 hide weigh_brood_1_input" name="weigh_brood_1_input" placeholder="Weigh brood 1 value">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="checkbox-card">
                                            <div class="form-group">
                                                <label class="checkbox-label">Prep for extraction
                                                    <input type="checkbox" name="prep_for_extraction" id="prep_for_extraction" value="1">
                                                    <span class="checkmark"></span>
                                                </label>                                                
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                                
                            </div>                            
                            <img src="{{ URL::asset('public/images/shap.png')}}" alt="">
                        </div>
                        
                        <div class="step-info-card step4 tab">
                            <div class="step-info">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-title">
                                            <h3>Inspection Step 4</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="checkbox-label">Feed Hive What?
                                            <input type="checkbox" name="feed_hive_what" id="feed_hive_what" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                            <input type="text" class="form-control mt-3 hide feed_hive_what_input" name="feed_hive_what_input" placeholder="Feed Hive What value">
                                        </div>                                        
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="checkbox-label">Install Medication What?
                                            <input type="checkbox" name="install_medication_what" id="install_medication_what" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                            <select name="install_medication_what_input" id="install_medication_what_input" class="form-control hide install_medication_what_input">
                                                <option value="">Select Pollen</option>
                                                <option value="Heavy">Formic</option>
                                                <option value="Moderate">Apivar</option>
                                                <option value="Low">Other</option>
                                            </select>
                                        </div>                                         
                                    </div>

                                    

                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="checkbox-card">
                                            <div class="form-group">
                                                <label class="checkbox-label">Remove Medication
                                                    <input type="checkbox" name="remove_medication" id="remove_medication" value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="checkbox-label">Split Hive
                                                    <input type="checkbox" name="split_hive" id="split_hive" value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="checkbox-label">Re Queen
                                                    <input type="checkbox" name="re_queen" id="re_queen" value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="checkbox-label">Swap Brood Boxes
                                                    <input type="checkbox" name="swap_brood_boxes" id="swap_brood_boxes" value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="checkbox-label">Insulate / Winterize
                                                    <input type="checkbox" name="insulate_winterize" id="insulate_winterize" value="1">
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="Additional Notes">Additional Notes</label>
                                            <textarea type="text" name="additional_notes" placeholder="Additional Notes" class="form-control" id="additional_notes" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                        
                            </div>
                            
                            <img src="{{ URL::asset('public/images/shap.png')}}" alt="">
                        </div> 

                        <div class="step-info-card step-button">
                            <div class="step-info">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="previous-btn">
                                            <a href="javascript:;" class="second_previous previous">Previous</a>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="next-btn">
                                            <a href="javascript:;" class="second_next next">NEXT</a>   
                                            <button type="submit" class="submit">Send Report</button>
                                            <button type="button" class="submit">See History</button>                                         
                                        </div>
                                    </div>

                                </div>
                            </div>    
                        </div>                           

                    </form>          
                </div>
            </div>
        </div>
    </section>

@endsection
@section('script')
    @if(Session::has('message'))
        <script>
        $(function() {
            toastr.{{ Session::get('alert-class') }}('{{ Session::get('message') }}');
        });
        </script>
    @endif

	<script type="text/javascript">
		$(document).ready(function(){	
			var val	=	{
			    rules: {
                    inspection_date: {
                        required: true
                    },
                    mite_count : {
                        required: true,
                    },
                    temperment: {
                        required: true
                    },
                    population : {
                        required: true,
                    },
                    brood : {
                        required: true,
                    },
                    honey : {
                        required: true,
                    },
                    pollen : {
                        required: true,
                    },
                    frames_of_bees: {
                        required: true
                    },
                    frames_of_brood : {
                        required: true,
                    },
                    frames_of_honey : {
                        required: true,
                    },
                    frames_of_pollen : {
                        required: true,
                    }
			    },
			    messages: {
					inspection_date: {
						required:"Inspection date is required",
					},
					mite_count: {
						required:"Mite count is required",
					},
					temperment:{
						required:"Temperment is requied"
					},
					population:{
						required:"Population is required"
					},
					brood:{
						required:"Brood is required",
					},
					honey:{
						required:"Honey is required",
					},
					pollen:{
						required:"Pollen is required",
					},
					frames_of_bees:{
						required:"Frames of bees is required",
					},                   
                    frames_of_brood : {
                        required: "Frames of brood required",
                    },
                    frames_of_honey : {
                        required: "Frames of honey required",
                    },
                    frames_of_pollen : {
                        required: "Frames of pollen required",
                    }
			    }
			}
			$("#inspectionForm").multiStepForm(
			{
				// defaultStep:0,
				beforeSubmit : function(form, submit){
					console.log("called before submiting the form");
					console.log(form);
					console.log(submit);
                   

				},
				validations:val,
			}
			).navigateTo(0);
		});
	</script>




<script>

$(document).ajaxStart(function() { Pace.restart(); });
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function () {    
    
    $("#solid_uniform_frames").change(function() {
        if(this.checked) {
            $('.solid_uniform_frames_input').removeClass('hide');
        }else{
            $('.solid_uniform_frames_input').addClass('hide');     
        }
    });

    $("#slightly_spotty_frames").change(function() {
        if(this.checked) {
            $('.slightly_spotty_frames_input').removeClass('hide');
        }else{
            $('.slightly_spotty_frames_input').addClass('hide');     
        }
    });

    $("#honey_supers").change(function() {
        if(this.checked) {
            $('.honey_supers_input').removeClass('hide');
        }else{
            $('.honey_supers_input').addClass('hide');     
        }
    });

    $("#add_supers").change(function() {
        if(this.checked) {
            $('.add_supers_input').removeClass('hide');
        }else{
            $('.add_supers_input').addClass('hide');     
        }
    });

    $("#weigh_super_3").change(function() {
        if(this.checked) {
            $('.weigh_super_3_input').removeClass('hide');
        }else{
            $('.weigh_super_3_input').addClass('hide');     
        }
    });

    $("#weigh_super_2").change(function() {
        if(this.checked) {
            $('.weigh_super_2_input').removeClass('hide');
        }else{
            $('.weigh_super_2_input').addClass('hide');     
        }
    });

    $("#weigh_super_1").change(function() {
        if(this.checked) {
            $('.weigh_super_1_input').removeClass('hide');
        }else{
            $('.weigh_super_1_input').addClass('hide');     
        }
    });

    $("#weigh_brood_3").change(function() {
        if(this.checked) {
            $('.weigh_brood_3_input').removeClass('hide');
        }else{
            $('.weigh_brood_3_input').addClass('hide');     
        }
    });

    $("#weigh_brood_2").change(function() {
        if(this.checked) {
            $('.weigh_brood_2_input').removeClass('hide');
        }else{
            $('.weigh_brood_2_input').addClass('hide');     
        }
    });

    $("#weigh_brood_1").change(function() {
        if(this.checked) {
            $('.weigh_brood_1_input').removeClass('hide');
        }else{
            $('.weigh_brood_1_input').addClass('hide');     
        }
    });

    $("#feed_hive_what").change(function() {
        if(this.checked) {
            $('.feed_hive_what_input').removeClass('hide');
        }else{
            $('.feed_hive_what_input').addClass('hide');     
        }
    });

    $("#install_medication_what").change(function() {
        if(this.checked) {
            $('.install_medication_what_input').removeClass('hide');
        }else{
            $('.install_medication_what_input').addClass('hide');     
        }
    });
    
});


	
</script>

@endsection
