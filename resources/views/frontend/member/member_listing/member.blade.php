@extends('frontend.layouts.app')
@section('content')

<section class="py-4 py-lg-5 bg-white" >
  <div class="container">
      <div class="row">
          <div class="col-12">
              <div class="row">
                  <div class="col-xl-3">
                      @include('frontend.member.member_listing.filter-search')
                  </div>
                  
                  <div class="col-xl-9">
                      
                      
                      <div class="mb-5">
                          @foreach ($users as $key => $user)
                              <div class="row no-gutters border border-gray-300 rounded hov-shadow-md mb-4 has-transition position-relative"
                                  id="block_id_{{ $user->id }}">
                                  <div class="col-md-auto">
                                      <div class="text-center text-md-left pt-3 pt-md-0">
                                          @php
                                              $avatar_image = $user->member->gender == 1 ? 'assets/img/avatar-place.png' : 'assets/img/female-avatar-place.png';
                                              $profile_picture_show = show_profile_picture($user);
                                          @endphp
                                          <img @if ($profile_picture_show) src="{{ uploaded_asset($user->photo) }}"
                                          @else
                                          src="{{ static_asset($avatar_image) }}" @endif
                                              onerror="this.onerror=null;this.src='{{ static_asset($avatar_image) }}';"
                                              class="img-fit mw-100 size-150px size-md-250px rounded-circle md-rounded-0">
                                      </div>
                                  </div>

                                  <div class="col-md position-static d-flex align-items-center">
                                 


                                      <div class="px-md-4 p-3 flex-grow-1">

                                          <h2 class="h6 fw-600 fs-18 text-truncate mb-1">
                                              {{ $user->first_name . ' ' . $user->last_name }}
                                            </h2>
                                          <div class="mb-2 fs-12">
                                              <span class="opacity-60">{{ translate('Member ID: ') }}</span>
                                              <span class="ml-4 text-primary">{{ $user->code }}</span>
                                          </div>
                                          <table class="w-100 opacity-70 mb-2 fs-12">
                                              <tr>
                                                  <td class="py-1 w-25">
                                                      <span>{{ translate('Age') }}</span>
                                                  </td>
                                                  <td class="py-1 w-25 fw-400">
                                                      {{ \Carbon\Carbon::parse($user->member->birthday)->age }}</td>
                                                  <td class="py-1 w-25"><span>{{ translate('Height') }}</span></td>
                                                  <td class="py-1 w-25 fw-400">
                                                      @if (!empty($user->physical_attributes->height))
                                                          {{ $user->physical_attributes->height }}
                                                      @endif
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <td class="py-1"><span>{{ translate('Religion') }}</span></td>
                                                  <td class="py-1 fw-400">
                                                      @if (!empty($user->spiritual_backgrounds->religion_id))
                                                          {{ $user->spiritual_backgrounds->religion->name }}
                                                      @endif
                                                  </td>
                                                  <td class="py-1"><span>{{ translate('Caste') }}</span></td>
                                                  <td class="py-1 fw-400">
                                                      @if (!empty($user->spiritual_backgrounds->caste_id))
                                                          {{ $user->spiritual_backgrounds->caste->name }}
                                                      @endif
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <td class="py-1"><span>{{ translate('First Language') }}</span>
                                                  </td>
                                                  <td class="py-1 fw-400">
                                                      @if ($user->member->mothere_tongue != null)
                                                          {{ \App\Models\MemberLanguage::where('id', $user->member->mothere_tongue)->first()->name }}
                                                      @endif
                                                  </td>
                                                  <td class="py-1"><span>{{ translate('Marital Status') }}</span>
                                                  </td>
                                                  <td class="py-1 fw-400">
                                                      @if ($user->member->marital_status_id != null)
                                                          {{ $user->member->marital_status->name }}
                                                      @endif
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <td class="py-1"><span>{{ translate('Location') }}</span></td>
                                                  <td class="py-1 fw-400">
                                                      @php
                                                          $present_address = \App\Models\Address::where('type', 'present')
                                                              ->where('user_id', $user->id)
                                                              ->first();
                                                      @endphp
                                                      @if (!empty($present_address->country_id))
                                                          {{ $present_address->country->name }}
                                                      @endif
                                                  </td>
                                              </tr>
                                          </table>
                                     
                                      </div>

                                  </div>
                              </div>
                          @endforeach

                      </div>
                      
                      <div class="aiz-pagination">
                          {{ $users->appends(request()->input())->links() }}
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>

    <!-- premium member Section -->
    @if (get_setting('show_premium_member_section') == 'on')
        <section class="py-9 bg-white">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-xl-8 col-xxl-6 mx-auto">
                        <div class="text-center section-title mb-5">
                            <h2 class="fw-600 mb-3 text-dark">{{ get_setting('premium_member_section_title') }}</h2>
                            <p class="fw-400 fs-16 opacity-60">{{ get_setting('premium_member_section_sub_title') }}</p>
                        </div>
                    </div>
                </div>
                <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="5" data-xl-items="4" data-lg-items="4"
                    data-md-items="3" data-sm-items="2" data-xs-items="1" data-dots='true' data-infinite='true'>
                    @foreach ($premium_members as $key => $member)
                        <div class="carousel-box">
                            @include('frontend.inc.member_box_1',['member'=>$member])
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif


    

    <!-- New Member Section -->
    @if (get_setting('show_new_member_section') == 'on')
        <section class="py-9 bg-white">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-xl-8 col-xxl-6 mx-auto">
                        <div class="text-center section-title mb-5">
                            <h2 class="fw-600 mb-3 text-dark">{{ get_setting('new_member_section_title') }}</h2>
                            <p class="fw-400 fs-16 opacity-60">{{ get_setting('new_member_section_sub_title') }}</p>
                        </div>
                    </div>
                </div>
                <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="5" data-xl-items="4" data-lg-items="4"
                    data-md-items="3" data-sm-items="2" data-xs-items="1" data-dots='true' data-infinite='true'>
                    @foreach ($new_members as $key => $member)
                        <div class="carousel-box">
                            @include('frontend.inc.member_box_1',['member'=>$member])
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

    @endif
    
    

@endsection

@section('modal')
    @include('modals.login_modal')
    @include('modals.package_update_alert_modal')
@endsection

@section('script')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script type="text/javascript">
        function loginModal() {
            $('#LoginModal').modal();
        }

        function package_update_alert() {
            $('.package_update_alert_modal').modal('show');
        }
        // making the CAPTCHA  a required field for form submission
        @if (get_setting('google_recaptcha_activation') == 1)
            $(document).ready(function(){
            $("#reg-form").on("submit", function(evt)
            {
            var response = grecaptcha.getResponse();
            if(response.length == 0)
            {
            //reCaptcha not verified
            alert("please verify you are humann!");
            evt.preventDefault();
            return false;
            }
            //captcha verified
            //do the rest of your validations here
            $("#reg-form").submit();
            });
            });
        @endif


        var isPhoneShown = true,
            countryData = window.intlTelInputGlobals.getCountryData(),
            input = document.querySelector("#phone-code");

        for (var i = 0; i < countryData.length; i++) {
            var country = countryData[i];
            if (country.iso2 == 'bd') {
                country.dialCode = '88';
            }
        }

        var iti = intlTelInput(input, {
            initialCountry: "auto",
            geoIpLookup: function(callback) {
                $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "us";
                    callback(countryCode);
                });
            },
            separateDialCode: true,
            utilsScript: "{{ static_asset('assets/js/intlTelutils.js') }}?1590403638580",
            onlyCountries: @php echo json_encode(\App\Models\Country::where('status', 1)->pluck('code')->toArray()) @endphp,
            customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                if (selectedCountryData.iso2 == 'bd') {
                    return "01xxxxxxxxx";
                }
                return selectedCountryPlaceholder;
            }
        });

        var country = iti.getSelectedCountryData();
        $('input[name=country_code]').val(country.dialCode);

        input.addEventListener("countrychange", function(e) {
            // var currentMask = e.currentTarget.placeholder;

            var country = iti.getSelectedCountryData();
            $('input[name=country_code]').val(country.dialCode);

        });

        function toggleEmailPhone(el) {
            if (isPhoneShown) {
                $('.phone-form-group').addClass('d-none');
                $('.email-form-group').removeClass('d-none');
                isPhoneShown = false;
                $(el).html('{{ translate('Use Phone Instead') }}');
            } else {
                $('.phone-form-group').removeClass('d-none');
                $('.email-form-group').addClass('d-none');
                isPhoneShown = true;
                $(el).html('{{ translate('Use Email Instead') }}');
            }
        }
    </script>
    <style>
.animated-text {
margin-right: -120px;
animation: pulse 2s infinite;
color:rgb(253, 44, 121);
}
 

@keyframes pulse {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.2);
  }
  100% {
    transform: scale(1);
  }
}
        </style>


@endsection
