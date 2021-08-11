<div>
    <!-- The only way to do great work is to love what you do. - Steve Jobs -->
    test
    {{ Auth::user()->email }}
    {{ $data1 }}
    @foreach ($authors as $value)
    $value
                                            <span class="nice">
                                                {{ $value->first_name }} {{ $value->middle_name }} {{ $value->last_name }}
                                                @if( !$loop->last)
                                                ,
                                                @endif
                                            </span>
                                        @endforeach
</div>