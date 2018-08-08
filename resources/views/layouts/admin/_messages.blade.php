@foreach (['danger', 'warning', 'success', 'info'] as $msg)
    @if(session()->has($msg))
        <div class="alert flash-message">
            <button type="button" class="close" data-dismiss="alert" >
                &times;
            </button>
            <p class="alert alert-{{ $msg }}">
                {{ session()->get($msg) }}
            </p>

        </div>
    @endif
@endforeach