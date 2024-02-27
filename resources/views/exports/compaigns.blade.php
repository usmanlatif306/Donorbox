<table>
    <thead>
        <tr>
            <th style="font-weight: 600;">{{ 'Name' }}</th>
            <th style="font-weight: 600;">{{ 'Rasied' }}</th>
            <th style="font-weight: 600;">{{ 'Goal' }}</th>
            <th style="font-weight: 600;">{{ 'Donors Count' }}</th>
            <th style="font-weight: 600;">{{ 'Created' }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($compaigns as $compaign)
            <tr>
                <td>{{ $compaign->name }}</td>
                <td>{{ $currency_sign }}{{ $compaign->total_raised }}</td>
                <td>{{ $currency_sign }}{{ $compaign->goal_amt }}</td>
                <td>{{ $compaign->donations_count }}</td>
                <td>{{ $compaign->created_at->format('d M y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
