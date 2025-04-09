@extends('layouts.master')
@section('title') Dashboard @endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1') @endslot
        @slot('title') COMPANY DETAILS @endslot
    @endcomponent

    @section('css')
        <style>
          .crm-table {
              border-collapse: separate;
              border-spacing:0 25px;
          }
        </style>

    @endsection

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="header-content" style="display: flex; justify-content: space-between; align-items: center;">
                      <div class="left-content" style="display: flex; align-items: center;">
                        @if(!empty($companyData->com_image))
                          <img src="{{asset('product_images')}}/{!! $companyData->com_image !!}" alt="">
                        @endif
                      </div>

                      <div class="right-content" style="display: flex; align-items: center;">
                        <!-- <a href="{{url('company')}}" class="btn btn-primary" style="margin-right: 5px;"><i class="dripicons-arrow-left" style="display: inline-flex;justify-content: center;align-items: center;width: 100%;height: 100%;"></i></a> -->
                        <a href="{{url('company/edit')}}/{{$comId}}" class="btn btn-sm btn-outline-success btn-circle me-2"><i class="dripicons-pencil"></i></a>
                      </div>
                    </div>
                  </div>

                <div class="card-body">
                    <div class="row">
                    <div class="col-md-6">
                        <table class="crm-table">
                            <tr>
                                <th width="200">COMPANY NAME</th>
                                <th width="20">:</th>
                                <td>
                                    @if(!empty($companyData->com_name))
                                      {!! $companyData->com_name !!}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th width="200">COMPANY CODE</th>
                                <th width="20">:</th>
                                <td>
                                    @if(!empty($companyData->com_code))
                                    {!! $companyData->com_code !!}
                                  @endif
                                </td>
                            </tr>
                            <tr>
                                <th width="200">REGISTRATION NO</th>
                                <th width="20">:</th>
                                <td>
                                    @if(!empty($companyData->com_reg_no))
                                    {!! $companyData->com_reg_no !!}
                                  @endif
                                </td>
                            </tr>
                            <tr>
                                <th width="200">EMAIL</th>
                                <th width="20">:</th>
                                <td>
                                    @if(!empty($companyData->com_email))
                                    {!! $companyData->com_email !!}
                                  @endif
                                </td>
                            </tr>

                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="crm-table">
                            <tr>
                                <th width="200">TELEPHONE</th>
                                <th width="20">:</th>
                                <td>
                                    @if(!empty($companyData->com_tel))
                                    {!! $companyData->com_tel !!}
                                  @endif
                                </td>
                            </tr>
                            <tr>
                                <th width="200">DEFAULT ADDRESS</th>
                                <th width="20">:</th>
                                <td>
                                    @if(!empty($companyData->com_address))
                                    {!! $companyData->com_address !!}
                                  @endif
                                </td>
                            </tr>
                            <tr>
                                <th width="200">CUSTOMER TYPE</th>
                                <th width="20">:</th>
                                <td>
                                    @if(!empty($companyData))
                                        @isset($companyData->companyTypes)

                                            @foreach($companyData->companyTypes as $type)

                                                @if ($loop->last)
                                                    {{ $type->type_name }}
                                                @else
                                                    {{ $type->type_name.',' }}
                                                @endif

                                            @endforeach
                                        @endisset
                                  @endif



                                </td>
                            </tr>
                            <tr>
                                <th width="200">TIER</th>
                                <th width="20">:</th>
                                <td>
                                    @if(!empty($companyData))
                                        @isset($companyData->companyTier)
                                            {!! $companyData->companyTier->tier_name !!}
                                        @endisset
                                    @endif
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>
                </div><!--end card-body-->
            </div><!--end card-->
        </div> <!-- end col -->

    </div>

@endsection
