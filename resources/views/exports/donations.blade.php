<table>
    <thead>
        <tr>
            <th style="font-weight: 600;">{{ 'Compaign Name' }}</th>
            <th style="font-weight: 600;">{{ 'Donor Name' }}</th>
            <th style="font-weight: 600;">{{ 'Donor Email' }}</th>
            <th style="font-weight: 600;">{{ 'Type' }}</th>
            <th style="font-weight: 600;">{{ 'Amount' }}</th>
            <th style="font-weight: 600;">{{ 'Fee' }}</th>
            <th style="font-weight: 600;">{{ 'Received' }}</th>
            <th style="font-weight: 600;">{{ 'Created' }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($donations as $donation)
            <tr>
                <td>{{ $donation->compaign?->name }}</td>
                <td>{{ $donation->donor?->name }}</td>
                <td>{{ $donation->donor?->email }}</td>
                <td>{{ $donation->type }}</td>
                <td>{{ $currency_sign }}{{ $donation->amount }}</td>
                <td>{{ $currency_sign }}{{ $donation->processing_fee }}</td>
                <td>{{ $currency_sign }}{{ $donation->culacted }}</td>
                <td>{{ $donation->created_at->format('d M y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
