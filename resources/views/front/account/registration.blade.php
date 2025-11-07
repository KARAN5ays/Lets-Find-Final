@extends('front.layouts.app')

@section('main')
<section class="section-5">
    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-5">
                    <h1 class="h3">Register</h1>
                    <form action="" name="registrationForm" id="registrationForm">
                        <div class="mb-3">
                            <label for="name" class="mb-2">Name*</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name">
                            <p></p>
                        </div> 
                        <div class="mb-3">
                            <label for="email" class="mb-2">Email*</label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="Enter Email">
                            <p class="text-danger" id="emailError"></p>
                        </div> 
                        <div class="mb-3">
                            <label for="password" class="mb-2">Password*</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password">
                            <p></p>
                        </div> 
                        <div class="mb-3">
                            <label for="confirm_password" class="mb-2">Confirm Password*</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Please confirm Password">
                            <p></p>
                        </div>
                        <div class="mb-3">
                            <label for="skills" class="mb-2">Skills*</label>
                            <input type="text" name="skills" id="skills" class="form-control" placeholder="Enter your skills">
                            <p></p>
                        </div>
                        <div class="mb-3">
                            <label for="experience" class="mb-2">Experience (in years)*</label>
                            <input type="number" name="experience" id="experience" class="form-control" placeholder="Enter years of experience" min="0">
                            <p></p>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input @error('terms') is-invalid @enderror" name="terms" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the<a href="{{ route('terms') }}" target="_blank">Terms and Conditions</a>
                                </label>
                            </div>
                            @error('terms')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <button class="btn btn-primary mt-2">Register</button>
                    </form>                    
                </div>
                <div class="mt-4 text-center">
                    <p>Have an account? <a href="{{ route('account.login') }}">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
<script>
$("#registrationForm").submit(function(e){
    e.preventDefault();
    var emailInput = $("#email").val();
    var emailPattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
    if (!emailPattern.test(emailInput)) {
        $("#email").addClass('is-invalid');
        $("#emailError").text("Only @gmail.com emails are allowed.");
        return;
    } else {
        $("#email").removeClass('is-invalid');
        $("#emailError").text("");
    }

    $.ajax({
        url: '{{ route("account.processRegistration") }}',
        type: 'post',
        data: $("#registrationForm").serializeArray(),
        dataType: 'json',
        success: function(response) {
            if (response.status == false) {
                var errors = response.errors;
                $.each(errors, function(key, value) {
                    $("#" + key).addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(value);
                });
            } else {
                alert("Successfully registered!");
                window.location.href='{{ route("account.login") }}';
            }
        }
    });
});
</script>
@endsection
