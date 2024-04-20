<x-mail::message>
    <h1>Hello! You have pending request!</h1>
    <h2>{{ $data['body'] }}</h2>
    <p>
        Click <a href="http://localhost:8000/request">here</a> to view the page.
    </p>
</x-mail::message>