@extends('layouts.panel')

@section('container')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">My Profile</h1>
</div>

<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card shadow">
      <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
          <li class="nav-item">
            <span class="nav-link active">Edit Profile</span>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('user-password.home') }}">Change Password</a>
          </li>
        </ul>
      </div>
      <form method="POST" enctype="multipart/form-data" action="{{ route('user-edit.update') }}" class="card-body">
        @csrf
  
        <div class="row">
          <div class="col-md-4">
  
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link active" id="pills-current-tab" data-toggle="pill" href="#pills-current" role="tab" aria-controls="pills-current" aria-selected="true">Current</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-update-tab" data-toggle="pill" href="#pills-update" role="tab" aria-controls="pills-update" aria-selected="false">Update</a>
              </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
              <div class="tab-pane fade show active" id="pills-current" role="tabpanel" aria-labelledby="pills-current-tab">
  
                @auth('admin')
                  @if (auth()->guard('admin')->user()->pp)
                    <img src="{{ auth()->guard('admin')->user()->pp }}" alt="{{ auth()->guard('admin')->user()->fullname }}" class="w-100 rounded-circle" />
                  @else
                    <img src="{{ Gravatar::src(auth()->guard('admin')->user()->email) }}" alt="{{ auth()->guard('admin')->user()->fullname }}" class="w-100 rounded-circle" />
                  @endif
                @endauth
      
                @auth('user')
                  @if (auth()->guard('user')->user()->pp)
                    <img src="{{ auth()->guard('user')->user()->pp }}" alt="{{ auth()->guard('user')->user()->fullname }}" class="w-100 rounded-circle" />
                  @else
                    <img src="{{ Gravatar::src(auth()->guard('user')->user()->email) }}" alt="{{ auth()->guard('user')->user()->fullname }}" class="w-100 rounded-circle" />
                  @endif
                @endauth
  
              </div>
              <div class="tab-pane fade" id="pills-update" role="tabpanel" aria-labelledby="pills-update-tab">
  
                <div class="form-group">
                  <label for="pp">Update Profile Picture</label>
                  <input type="file" name="pp" id="pp" class="form-control" />
  
                  <div class="text-muted form-text">Upload file with format <code>*.jpg, *.png, *.jpeg</code> only and less than 2MB.</div>
                </div>
  
              </div>
            </div>
  
          </div>
          <div class="col-md-8">
            
            <div class="form-group">
              <label for="fullname">Fullname</label>
              @auth('user')
              <input type="text" class="form-control" id="fullname" name="fullname" value="{{ auth()->guard('user')->user()->fullname }}" placeholder="Enter your fullname" />
              @endauth
              @auth('admin')
              <input type="text" class="form-control" id="fullname" name="fullname" value="{{ auth()->guard('admin')->user()->fullname }}" placeholder="Enter your fullname" />
              @endauth
            </div>
            
            <div class="form-group">
              <label for="email">Email Address</label>
              @auth('user')
              <input type="text" class="form-control" id="email" name="email" value="{{ auth()->guard('user')->user()->email }}" placeholder="Enter your email address" />
              @endauth
              @auth('admin')
              <input type="text" class="form-control" id="email" name="email" value="{{ auth()->guard('admin')->user()->email }}" placeholder="Enter your email address" />
              @endauth
            </div>
            
            @auth('user')
            <div class="form-group">
              <label for="study">Major</label>
              <input type="text" class="form-control" id="study" name="study" value="{{ auth()->guard('user')->user()->study }}" placeholder="Enter your major or study programs" />
            </div>
            
            <div class="form-group">
              <label for="university">University</label>
              <input type="text" class="form-control" id="university" name="university" value="{{ auth()->guard('user')->user()->university }}" placeholder="Enter your university (Acronims ar allowed)" />
            </div>
            
            <div class="form-group">
              <label for="date_birth">Date of Birth</label>
              <input type="date" class="form-control" id="date_birth" name="date_birth" value="{{ auth()->guard('user')->user()->date_birth }}" placeholder="Enter your birth date" />
            </div>
            
            <div class="form-group">
              <label for="phone_number">Date of Birth</label>
              <input type="number" class="form-control" id="phone_number" name="phone_number" value="{{ auth()->guard('user')->user()->phone_number }}" placeholder="Enter your phone number" />
            </div>
            @endauth
  
            <div><button type="submit" class="btn btn-primary"><i class="fas fa-save mr-2"></i><span>Save Data</span></button></div>
  
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('footer')
  <script>
    $('form').submit(function(e) {
      e.preventDefault();

      let those   = $(this)
      let method  = those.attr('method')
      let url     = those.attr('action')
      let data    = those.serialize()

      $.ajax({
        url         : url,
        type        : 'POST',
        data        : new FormData( this ),
        processData : false,
        contentType : false,

        beforeSend() {
          $('input').prop('disabled', true)
          $('button').prop('disabled', true)
        },
        success(e) {
          console.log(e);

          $('#pills-current img, .img-profile').attr('src', e.data.pp);

          Snackbar.show({
            pos: 'top-right',
            actionText: 'Close',
            width: '25%',
            text: e.message,
            textColor: '#FFFFFF',
            backgroundColor: '#1cc88a',
            actionTextColor: '#FFFFFF',
          });

          $('input').prop('disabled', false)
          $('button').prop('disabled', false)
        },
        error(e) {
          $('input').prop('disabled', false)
          $('button').prop('disabled', false)

          let response = e.responseJSON;
          console.log(e);

          Snackbar.show({
            pos: 'top-right',
            actionText: 'Close',
            width: '25%',
            text: response.message,
            textColor: '#FFFFFF',
            backgroundColor: '#e74a3b',
            actionTextColor: '#FFFFFF',
          });
        },
      });
    });
  </script>
@endsection
