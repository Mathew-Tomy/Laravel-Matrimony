@extends('frontend.layouts.member_panel')
@section('panel_content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Profile Visitors') }}</h5>
        </div>
        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ translate('Image') }}</th>
                        <th>{{ translate('Name') }}</th>
                    
                    </tr>
                </thead>
                <tbody>
                     @foreach ($dislike_users as $key => $visitor)
                     <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <a href="{{ route('member_profile', $visitor->id) }}" class="text-reset c-pointer">
                                @if (uploaded_asset($visitor->dislikeUser->photo) != null)
                                    <img class="img-md" src="{{ uploaded_asset($visitor->dislikeUser->photo) }}" height="45px" alt="{{ translate('photo') }}">
                                @else
                                    <img class="img-md" src="{{ static_asset('assets/img/avatar-place.png') }}" height="45px" alt="{{ translate('photo') }}">
                                @endif
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('member_profile', $visitor->id) }}" class="text-reset c-pointer">
                                {{ $visitor->dislikeUser->first_name . ' ' . $visitor->dislikeUser->last_name }}
                            </a>
                        </td>
                    </tr>
                @endforeach
                 
                
                
                </tbody>
            </table>
            {{-- <div class="aiz-pagination">
                {{ $dislike_users->links() }}
            </div> --}}
        </div>
    </div>
@endsection
