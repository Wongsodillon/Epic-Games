@extends("profile")

@section("profile-content")
<div class="content">
    <div class="section-container">
        <p class="title">Transactions</p>
        <p class="section-info">Your account payment details, transactions and earned Epic Rewards.</p>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Marketplace</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $t)
                <tr class="data-tr">
                    <td>{{ \Carbon\Carbon::parse($t->created_at)->format('n/d/Y') }}</td>
                    <td class="game-data">{{ $t->name }}</td>
                    <td>IDR {{ number_format($t->payment) }}</td>
                    <td>Epic Games Store</td>
                    <td>Purchased</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
