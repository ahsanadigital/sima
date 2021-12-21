@extends('layouts.main')

@section('container')
<div class="py-3 py-md-0">
  <div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
      <div class="col-md-7 d-md-none d-lg-inline d-none" style="border-right: 1px solid rgb(255 255 255 / 25%)">
        <div class="p-5">

          <!-- Inline Row -->
          <div class="row">
            <div class="col-4">
              <img src="{{ asset('images/logo.png') }}" class="w-100" />
            </div>
            <div class="col-8">
              <img src="{{ asset('images/saly.png') }}" class="w-100" />
            </div>
          </div>

        </div>
      </div>
      <div class="col-md-5">
        <div class="p-0 p-md-5">

          <!-- Navigation -->
          <div class="nav justify-content-center mb-3">
            <a href="javascript:void(0)" class="nav-link text-white border-bottom">Login</a>
            <a href="{{ url('register') }}" class="nav-link text-white">Register</a>
          </div>

          <!-- Login Card -->
          <div class="card card-body shadow">
            <div class="text-center">
              <h3 class="text-primary">Welcome Back!</h3>
              <p class="mb-0">Enter your credentials here.</p>
            </div>

            <hr>

            <!-- Form Initialize -->
            <form action="{{ route('login.process') }}" method="post">
              @csrf

              <!-- Username Input -->
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" />
              </div>

              <!-- Password Input -->
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" />
              </div>

              <!-- Remember Checkbox -->
              <div class="form-group">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="remember" name="remember" value="true" />
                  <label class="custom-control-label" for="remember">Remember me</label>
                </div>
              </div>

              <!-- Submit Button -->
              <button type="submit" class="btn btn-primary btn-block mb-3">Log-In</button>

            </form>
          </div>

        </div>
      </div>
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
        url   : url,
        type  : 'POST',
        data  : data,

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

          setTimeout(() => {
            window.location.href = e.redirect
          }, 5000);
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
