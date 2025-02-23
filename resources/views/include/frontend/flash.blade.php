@if (session('message'))
<div class="alert alert-{{ session('alert-type') }} alert-dismissible fade show" role="alert" id="alert-message">


    </div>

    {{ session('message')}}
    
@endif



@if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert-message">
   
        {{ session('status') }}
        
       
    </div>
@endif



@if (session('resent'))

    <div class="alert alert-success alert-dismissible fade show" role="alert" id="alert-message">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">

<span aria-hidden="true">&times;</span>

</button>
        {{ __('A fresh verification link has been sent to your email address.') }}

        
    </div>
@endif