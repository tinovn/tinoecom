@if (! empty(config('tinoecom.admin.resources.scripts')))
    <!-- Additional Javascript -->
    @foreach (config('tinoecom.admin.resources.scripts') as $js)
        @if (\Illuminate\Support\Str::of($js)->startsWith(['http://', 'https://']))
            <script type="text/javascript" src="{!! $js !!}"></script>
        @else
            <script type="text/javascript" src="{{ asset($js) }}"></script>
        @endif
    @endforeach
@endif

@stack('scripts')
