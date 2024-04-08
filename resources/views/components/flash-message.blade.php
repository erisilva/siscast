@props(['status', 'message'])
@if(Session::has($message))
  <div class="alert alert-{{ $status }} alert-dismissible fade show" role="alert">
    <h4><x-icon icon='exclamation-triangle' /> {{ session($message) }}</h4>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif