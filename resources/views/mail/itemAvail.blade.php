<x-mail::message>
# Items Available
 
{{$item->name}} is now available!
 
<x-mail::button :url="/Items">
View Available Items
</x-mail::button>
 
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>