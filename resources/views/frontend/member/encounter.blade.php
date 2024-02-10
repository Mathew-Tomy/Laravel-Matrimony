@extends('frontend.layouts.member_panel')
@section('panel_content')
@if (count($encounter_users) > 0)
<div class="lw-random-user-block">
    {{-- @if($user->isPremiumUser) --}}
    <span class="lw-premium-badge" title=""></span>
    {{-- @endif --}}
    <!-- user name -->
    <div class="lw-user-text">
        <a class="btn btn-link lw-user-text-link" href="">
            {{ $encounter_users->first()->first_name . ' ' . $encounter_users->first()->last_name }}
           
        </a>
    </div>

    <div class="lw-profile-image-card-container lw-encounter-page">
        <!-- user image -->    
        <img src="{{uploaded_asset($encounter_users->first()->photo) }}" class="lw-lazy-img lw-profile-thumbnail">
        <!-- /user image -->
        <!-- user image -->
        <img src="{{uploaded_asset($encounter_users->first()->photo) }}" class="lw-lazy-img lw-cover-picture">
        <!-- /user image -->
    </div>

    <!-- action buttons -->
    <div class="lw-user-action-btn">
        @if (!$encounter_users->isEmpty())
    <a href="{{ route('encounter.like_user', ['user_id' => $encounter_users->first()->id]) }}" class="lw-ajax-link-action lw-like-dislike-btn mr-3" title="Like" id="lwLikeBtn"><i class="las la-thumbs-up"></i></a>

        <!-- like btn -->
        
        <!-- /like btn -->

        <!-- skip btn -->
        <a href="{{ route('encounter.skip_user', ['user_id' => $encounter_users->first()->id]) }}"   class="lw-ajax-link-action lw-like-dislike-btn lw-skip-btn mr-3"  id="lwSkipBtn"><i class="las la-chevron-right"></i></a>
        <!-- /skip btn -->

        <!-- Dislike btn -->
        <a href="{{ route('encounter.dislike_user', ['user_id' => $encounter_users->first()->id]) }}" data-action="" data-callback="onLikeDisLikeCallback"  class="lw-ajax-link-action lw-like-dislike-btn mr-3" title="Dislike" id="lwDislikeBtn"><i class="las la-thumbs-down"></i></a>
        <!-- /Dislike btn -->
        @endif
    </div>
</div>
@else
<div class="row gutters-5">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h2 class="fs-16 mb-0">No encounter users found.</h2>
            </div>
            <div class="card-body">
                <div class="text-center mb-4 mt-3">
                    <img class="mw-100 mx-auto mb-4"  src="{{ static_asset('assets/img/avatar-place.png') }}"   alt="{{translate('photo')}}" height="130">
                    <h5 class="mb-3 h5 fw-600"></h5>
                </div>
            </div>
        </div>
    </div>
</div>
              
              
                
            
 
@endif
@endsection

<script>
	//disabled button on click
	$("#lwLikeBtn, #lwSkipBtn, #lwDislikeBtn").on('click', function(e) {
		$("#lwLikeBtn, #lwSkipBtn, #lwDislikeBtn").addClass('lw-disable-anchor-tag');
	});

	//on like Callback function
	function onLikeDisLikeCallback(response) {
		var requestData = response.data;
		//check reaction code is 1
		if (response.reaction == 1 && requestData.likeStatus == 1) {
			__Utils.viewReload();
		} else if (response.reaction == 1 && requestData.likeStatus == 2) {
			__Utils.viewReload();
		}
	}

	//on encounter(skip) user Callback function
	function onEncounterUserCallback(response) {
		//check reaction code is 1
		if (response.reaction == 1) {
			__Utils.viewReload();
		}
	}
</script>