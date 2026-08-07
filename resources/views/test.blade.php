@php
    $records = [60, 70, 80];
@endphp
@if (count($records) == 1)
    <div>I have one record! </div>
@elseif (count($records) > 1)
    <div>I have multiple records!</div>
@else
    <div>I don't have any records!</div>
@endif

@php
    $i = 5;
@endphp
@switch($i)
    @case(1)
        //do First case...
    @break

    @case(2)
        //do Second case...
    @break

    @case('helloworld')
        //do String case...
    @break

    @default
        //do Default case...
@endswitch

@for ($i = 0; $i < 10; $i++)
   <div> The current value is {{ $i }} </div>
@endfor