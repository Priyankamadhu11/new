<html>
    <table>
        <thead>
            <tr>
                <th style="font-size:18px">{{translate($data['type'].'_'.'Transactions')}}</th>
            </tr>
            <tr>

                <th>{{translate('search_Criteria')}} -</th>
                <th></th>
                <th>

                    {{translate('customer')}} - {{ucwords($data['customer'] == 'all_customers' ? translate('all_customers') : $data['customer']['f_name'].' '.$data['customer']['l_name'])}}
                    <br>
                    {{translate('transaction_Type')}} - {{!empty($data['transaction_type']) ?  translate($data['transaction_type']) : translate('all')}}
                    <br>

                        {{translate('from')}} - {{ $data['from'] ? date('d M, Y',strtotime($data['from'])) : '' }}
                    <br>
                        {{translate('to')}} - {{$data['to'] ? date('d M, Y',strtotime($data['to'])) : '' }}
                    <br>
                </th>
            </tr>

            <tr>

                <th>{{ translate('search_Summary') }} -</th>
                <th></th>
                <th>
                    {{translate('total_Debit')}}  - {{$data['type'] == 'wallet' ? \App\CPU\Helpers::currency_converter($data['debit']) : $data['debit']}}
                </th>
                <th></th>
                <th></th>
                <th>
                    {{translate('total_Credit')}}  - {{$data['type'] == 'wallet' ? \App\CPU\Helpers::currency_converter($data['credit']) : $data['credit']}}
                </th>
            </tr>

            <tr>
                <td> {{translate('SL')}}	</td>
                <td> {{translate('transaction_ID')}}	</td>
                <td> {{translate('customer_Name')}}	</td>
                <td> {{translate('credit')}}</td>
                <td> {{translate('debit')}}</td>
                <td> {{translate('balance')}}</td>
                <td> {{translate('transaction_Type')}}</td>
                <td> {{translate('reference')}}</td>
                <td> {{translate('date')}}</td>
            </tr>
            <!-- loop  you data -->
            @foreach ($data['transactions'] as $key=>$item)
                <tr>
                    <td> {{++$key}}	</td>
                    <td>{{$item->transaction_id}}</td>
                    <td>{{ucwords(($item->user?->f_name ?? translate('customer_not_found')).' '.$item->user?->l_name)}}</td>
                    @if ($data['type'] == 'wallet')
                        <td>{{\App\CPU\Helpers::currency_converter($item->credit)}}</td>
                        <td>{{\App\CPU\Helpers::currency_converter($item->debit)}}</td>
                        <td>{{\App\CPU\Helpers::currency_converter($item->balance)}}</td>
                    @elseif($data['type'] == 'loyalty')
                        <td>{{$item->credit}}</td>
                        <td>{{$item->debit}}</td>
                        <td>{{$item->balance}}</td>
                    @endif

                    <td> {{translate($item->transaction_type)}}</td>
                    <td>{{translate(str_replace('_',' ',$item->reference)) }}</td>
                    <td>{{date('d M, Y',strtotime($item->created_at))}}</td>
                </tr>
            @endforeach
            <!-- end -->
        </thead>
    </table>
</html>
