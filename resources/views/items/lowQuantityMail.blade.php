@component(mail::message)

    <h1 style="text-align:center;font-size:50px;font-weight:bold">
        You're running low on items in your inventory...
    </h1>

    Thanks, <br>
    {{ config('app.name') }}
@endcomponent
