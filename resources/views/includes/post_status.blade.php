@if (count($errors) > 0)
    
          <div class="card-alert card red">
          <div class=" card-content white-text">
              
                  @foreach ($errors->all() as $error)
                  <p> - {{ $error }}</p>
                  @endforeach
              
              </div>
              <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
          </div>
        @endif
     
        @if(isset($post_status) && $post_status=="SUCCESS")
        <div class="card-alert card green">
            <div class="card-content white-text">
                <p>SUCCESS - </b> {{$post_status_message}}</p>
            </div>
            <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        
          @elseif(isset($post_status) && $post_status=="FAILED")
          <div class="card-alert card red">
            <div class="card-content white-text">
                <p>Failed - </b> {{$post_status_message}}</p>
            </div>
            <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
          </div>      
            
          @else
          @endif