@if (session()->has('success') || session()->has('error'))
 <!-- Session Message Display messages -->           
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible mb-0">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-check"></i> Success... !</h5>                  
                  {{ session('success') }}
                </div> <!-- alert -->
            @elseif (session()->has('error'))
                <div class="alert alert-danger alert-dismissible mb-0">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Fail... !</h5>
                  {{ session('error') }}
                 </div>            
            @endif         
   <!-- Session Message Display messages Ends -->
  @endif

    
