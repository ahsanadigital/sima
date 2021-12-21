@extends('layouts.panel')

@section('container')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Change Password</h1>
</div>

<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card shadow">
      <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('user-edit.home') }}">Edit Profile</a>
          </li>
          <li class="nav-item">
            <span class="nav-link active">Change Password</span>
          </li>
        </ul>
      </div>
      <form method="POST" action="{{ route('user-password.update') }}" class="card-body">
        @csrf
            
        <div class="form-group">
          <label for="password">Enter Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" />
        </div>
            
        <div class="form-group">
          <label for="password_confirm">Confirm The Password</label>
          <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Enter your password" />
        </div>
  
        <div><button type="submit" class="btn btn-primary"><i class="fas fa-save mr-2"></i><span>Save Password</span></button></div>
  
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

          Snackbar.show({
            pos: 'top-right',
            actionText: 'Close',
            width: '25%',
            text: e.message,
            textColor: '#FFFFFF',
            backgroundColor: '#1cc88a',
            actionTextColor: '#FFFFFF',
          });

          $('input').prop('disabled', false).val('')
          $('button').prop('disabled', false)
        },
        error(e) {
          $('input').prop('disabled', false)
          $('button').prop('disabled', false)

          let response = e.responseJSON;

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