@extends((Auth::user()->id == 1) ? "layouts.admin" : "layouts.user")

@section('page_title')
Edit Profile
@endsection

@section('page_body')
<div class="jumbotron font-weight-bold m-0">
	<div class="container m-0">
		<h1 class="text-center">Update Your Profile</h1>
		<form class="row m-0 p-2" method="POST">
			{{ csrf_field() }}
			Your Name
			<input type="text" class="form-control font-weight-bold mb-3" id="display_name" name="display_name" value="{{ Auth::user()->name }}" placeholder="Your Name" required>
			Your Phone Number &nbsp; <span id="phoneInvalid" style="display: none" class="help-block text-danger">
                                        <strong>(Please use correct phone number formatting!)<br></strong>
                                    </span>
			<input type="text" minlength="11" class="form-control font-weight-bold mb-3" id="phone" name="phone" value="{{ Auth::user()->phone }}" placeholder="+8801XXXXXXXXX" required>
			New Password
			<input type="password" minlength="5" class="form-control font-weight-bold mb-3" name="update_password" placeholder="*****">
			Repeat New Password
			<input type="password" minlength="5" class="form-control font-weight-bold mb-3" name="update_password1" placeholder="*****">
			Current Password (Required for making update)
			<input type="password" minlength="5" class="form-control font-weight-bold mb-3" name="password" placeholder="*****" required>
			<div class="text-right"><button id="updBtn" class="btn btn-primary my-3">Update Profile</button></div>
		</form>
	</div>
</div>
<script type="text/javascript">
    $('input[name="phone"]').keyup(function() {
        var phone = $('input[name="phone"]').val();
        if (phone === "") {
            $('#phoneInvalid').css('display','none');
            $('#updBtn').removeAttr('disabled');
            $('#phoneInvalid').fadeOut("slow");
        }
        var type1 = /^\+\d+$/.test(phone); //+880xxxxxxxxx
        var type2 = /^\d+$/.test(phone); //017xxxxxxxxx
        if (type1 === true || type2 === true)
        {
            // a perfect number format
            $('#phoneInvalid').css('display','none');
            $('#updBtn').removeAttr('disabled');
            $('#phoneInvalid').fadeOut("slow");
        }
        else
        {
            $('#phoneInvalid').css('display','block');
            $('#updBtn').attr('disabled','disabled');
            $('#phoneInvalid').fadeIn("slow");
        }
    });
</script>
@endsection