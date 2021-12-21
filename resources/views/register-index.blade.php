@extends('layouts.main')

@section('container')

<div class="py-3 py-md-0">
  <div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
      <div class="col-md-6">
        <div class="p-0 p-md-5">

          <!-- Navigation -->
          <div class="nav justify-content-center mb-3">
            <a href="{{ url('register') }}" class="nav-link text-white">Login</a>
            <a href="javascript:void(0)" class="nav-link text-white border-bottom">Register</a>
          </div>

          <!-- Login Card -->
          <div class="card card-body shadow">
            <div class="text-center">
              <h3 class="text-primary">Welcome Back!</h3>
              <p class="mb-0">Enter your credentials here.</p>
            </div>

            <hr>

            <!-- Form Initialize -->
            <form action="{{ route('register.process') }}" method="post">
              @csrf

              <div class="form-group">
                <label for="username">Username <span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="{{ old('username') }}" id="username" name="username" placeholder="Enter your username" />
              </div>

              <div class="form-group">
                <label for="fullname">Fullname <span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="{{ old('fullname') }}" id="fullname" name="fullname" placeholder="Enter your fullname" />
              </div>
              
              <div class="form-group">
                <label for="email">Email Address <span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="{{ old('email') }}" id="email" name="email" placeholder="Enter your email address" />
              </div>
              
              <div class="form-group">
                <label for="study">Major</label>
                <input type="text" class="form-control" value="{{ old('study') }}" id="study" name="study" placeholder="Enter your major or study programs" />
              </div>
              
              <div class="form-group">
                <label for="university">University <span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="{{ old('university') }}" id="university" name="university" placeholder="Enter your university (Acronims ar allowed)" />
              </div>
              
              <div class="form-group">
                <label for="date_birth">Date of Birth <span class="text-danger">*</span></label>
                <input type="date" class="form-control" value="{{ old('date_birth') }}" id="date_birth" name="date_birth" placeholder="Enter your birth date" />
              </div>
              
              <div class="form-group">
                <label for="phone_number">Phone Number <span class="text-danger">*</span></label>
                <input type="number" class="form-control" value="{{ old('phone_number') }}" id="phone_number" name="phone_number" placeholder="Enter your phone number" />
              </div>

              <!-- Submit Button -->
              <button type="submit" class="btn btn-primary btn-block mb-3">Sign Up</button>

              <!-- Forgot Password Section -->
              <div class="text-center">
                <a href="{{ url('login') }}">Go Back</a>
              </div>

            </form>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection