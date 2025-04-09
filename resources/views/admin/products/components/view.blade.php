<div class="col-md-6">
    <table class="table table-responsive shp_table">
        <tr>
            <th width="180" class="table-head-cust">Contact Name</th>
            <th width="10" class="table-head-cust">:</th>
            <td class="table-head-cust">
                @if(!empty($userDetails->com_name))
                {{$userDetails->com_name }}
                @endif
            </td>
        </tr>

        <tr>
            <th width="180" >City</th>
            <th width="10">:</th>
            <td>
                @if(!empty($userDetails->com_city))
                {{$userDetails->com_city }}
                @endif
            </td>
        </tr>
        <tr>
            <th width="180" >Tel No</th>
            <th width="10">:</th>
            <td>
                @if(!empty($userDetails->com_tel))
                {{$userDetails->com_tel }}
                @endif
            </td>
        </tr>
        <tr>
            <th width="180" >Country Name</th>
            <th width="10">:</th>
            <td>
                @if(!empty($userDetails->country->country_name))
                {{$userDetails->country->country_name }}
                @endif
            </td>
        </tr>
        <tr>
            <th width="180" > EXISTING CUSTOMER </th>
            <th width="10">:</th>
            <td>
                @if(!empty($userDetails->existing_cus))
                {{$userDetails->existing_cus }}
                @endif
            </td>
        </tr>
        <tr>
            <th width="180" > CONTACT LOCATION </th>
            <th width="10">:</th>
            <td>
                @if(!empty($userDetails->com_state))
                {{$userDetails->com_state }}
                @endif
            </td>
        </tr>
    </table>
</div>

<div class="col-md-6">
    <table class="table table-responsive shp_table">
        <tr>
            <th width="180" class="table-head-cust">SHORT TAG</th>
            <th width="10" class="table-head-cust">:</th>
            <td class="table-head-cust">
                @if(!empty($userDetails->com_stag))
                {{$userDetails->com_stag }}
                @endif
            </td>
        </tr>
        <tr>
            <th width="180" > POSTAL CODE </th>
            <th width="10">:</th>
            <td>
                @if(!empty($userDetails->com_zip))
                {{$userDetails->com_zip }}
                @endif
            </td>
        </tr>
        <tr>
            <th width="180" > Email </th>
            <th width="10">:</th>
            <td>
                @if(!empty($userDetails->com_email))
                {{$userDetails->com_email }}
                @endif
            </td>
        </tr>

        <tr>
            <th width="180" > CONTACT TYPE </th>
            <th width="10">:</th>
            <td>
                @if(!empty($userDetails->cus_type))
                {{$userDetails->cus_type }}
                @endif
            </td>
        </tr>

        <tr>
            <th width="32%" > Customer Type </th>
            <th >:</th>
            <td>
                @foreach ($userDetails->customerType as $key => $type)
                <span class="label label-success cust-type">  {{ $type->name }} </span>
                @endforeach
            </td>
        </tr>


    </table>
</div>
@if($userDetails->locationAddress->isEmpty() != true)
<div class="col-md-12">
    <table class="table table-responsive shp_table">
        <tr><h5>OTHER ADDRESS</h5></tr>
    </table>
</div>
@endif
    @foreach ($userDetails->locationAddress as $key => $address)
        <table class="table table-responsive shp_table">
            <tr>
                @if(isset($address->location))
                    <td width='33%'> <span class="location-style">LOCATION {{ $key }} </span> :  {{ $address->location }}</td>
                @endif

                @if(isset($address->location_address))
                    <th width="90" > ADDRESS {{ $key+1 }} </th>
                    <th width="10">:</th>
                    <td>{{ $address->location_address }}</td>
                @endif
            </tr>
        </table>
    @endforeach
