@foreach($plans as $plan)
    <div>
        <h3>{{ $plan->name }}</h3>
        <p>Price: Rs. {{ $plan->price }}</p>
        <p>Duration: {{ $plan->duration }} days</p>
        <form action="{{ route('subscriptions.process') }}" method="POST">
            @csrf
            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
            <button type="submit">Subscribe</button>
        </form>
    </div>
@endforeach
@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif
@if(session('error'))
    <p style="color: red;">{{ session('error') }}</p>
@endif
