@php $price_symbol = getSetting()->default_symbol ?? '$'; @endphp
@php $ASSET_URL = asset('admin-theme').'/'; @endphp
@extends('admin.layouts.app')
@section('content')
    <div class="tp_main_content_wrappo">
        <div class="tp_tab_wrappo">
            <ul>
                <li><a href="{{ route('admin.order.index') }}">Order List</a> </li>
            </ul>
        </div>
        <div class="tp_tab_content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tp_catset_box tp_catset_singleuser">
                        <div role="tabpanel" class="tab-pane active" id="info">
                            <div class="th_content_section">
                                <div class="th_product_detail">
                                    <div class="theme_label">Order Id :</div>
                                    <div class="product_info product_name">{{ @$data->id }}</div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Transaction Id :</div>
                                    <div class="product_info product_name">{{ @$data->tnx_id }}</div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Customer :</div>
                                    <div class="product_info product_name">{{ @$data->getUser->full_name }}</div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Billing email :</div>
                                    <div class="product_info product_name">{{ @$data->getUser->email }}</div>
                                </div>

                                <div class="th_product_detail">
                                    <div class="theme_label">Payment Id :</div>
                                    <div class="product_info product_name">{{ @$data->payment_id ?? 'NA' }}</div>
                                </div>
                                
                                <div class="th_product_detail">
                                    <div class="theme_label">Payer Id / Reference Number :</div>
                                    <div class="product_info product_name">{{ @$data->payer_id ?? 'NA' }}</div>
                                </div>


                                <div class="th_product_detail">
                                    <div class="theme_label">Billing Discount Code :</div>
                                    <div class="product_info product_name">{{ @$data->billing_discount_code ?? 'NA' }}</div>
                                </div>

                                <div class="th_product_detail">
                                    <div class="theme_label">Gateway :</div>
                                    <div class="product_info status">{{ @$data->payment_gateway }}</div>
                                </div>

                                <div class="th_product_detail">
                                    <div class="theme_label">Created at : </div>
                                    <div class="product_info">{{ set_date_with_time(@$data->created_at) }}</div>
                                </div>
                                <div class="th_product_detail">
                                    <div class="theme_label">Updated at : </div>
                                    <div class="product_info">{{ set_date_with_time(@$data->updated_at) }}</div>
                                </div>

                                <div class="th_product_detail">
                                    <div class="theme_label">Billing Subtotal :</div>
                                    <div class="product_info product_name">{{ @$price_symbol . @$data->billing_subtotal }}
                                    </div>
                                </div>

                                <div class="th_product_detail">
                                    <div class="theme_label">Billing tax :</div>
                                    <div class="product_info product_name">{{ @$price_symbol . @$data->billing_tax }}
                                    </div>
                                </div>

                                <div class="th_product_detail">
                                    <div class="theme_label">Billing Discount :</div>
                                    <div class="product_info product_name">
                                        {{ @$price_symbol . @$data->billing_discount ?? 0 }}</div>
                                </div>

                                <div class="th_product_detail">
                                    <div class="theme_label">Total : </div>
                                    <div class="product_info">{{ @$price_symbol . @$data->billing_total }}</div>
                                </div>

                                <div class="th_product_detail">
                                    <div class="theme_label">Status : </div>
                                    <div class="product_info">{{ @$data->status_str }}</div>
                                </div>
                            

                            </div>
                            <h3>Order Details</h3>
                            <hr>
                            <div class="table-responsive">
                                <table id="example" class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product</th>
                                            <th></th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (@$data->getOrderProduct)
                                        @php $i=0 @endphp
                                            @foreach ($data->getOrderProduct as $key => $items2)

                                                
                                                @foreach ($items2->getProduct as $key3 => $item3)
                                                    @if (!empty($items2->variants))
                                                        @php $variants = unserialize($items2->variants); @endphp
                                                        @foreach ($variants as $v => $v_itmes)
                                                            <tr>
                                                                <td>{{ ++$i }}</td>
                                                                <td>{{ $item3->name . ' ' . $v_itmes['option_name'] }}</td>
                                                                <td></td>
                                                                <td>{{ @$price_symbol . @$v_itmes['price'] }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td>{{ ++$i}}</td>
                                                            <td>{{ $item3->name }}</td>
                                                            <td></td>
                                                            <td>{{ @$price_symbol . @$items2->price }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                            <tr>
                                                <td colspan="2" class="border-0"></td>
                                                <td class="text-right pl-0">Sub Total</td>
                                                <td class="text-right pr-0">
                                                    {{ @$price_symbol . @$data->billing_subtotal }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="border-0"></td>
                                                <td class="text-right pl-0">Total Tax</td>
                                                <td class="text-right pr-0">
                                                    {{ @$price_symbol . @$data->billing_tax }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="border-0"></td>
                                                <td class="text-right pl-0">Discount</td>
                                                <td class="text-right pr-0">
                                                    {{ @$price_symbol . @$data->billing_discount }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="border-0"></td>
                                                <td class="text-right pl-0 "><strong>Total</strong></td>
                                                <td class="text-right pr-0">
                                                    <strong>{{ @$price_symbol . @$data->billing_total }}</strong>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="7" class="text-center">No Record Found.</td>
                                            </tr>
                                        @endif

                                    </tbody>
                                </table>
                               
                                 
                            </div>
                          
                            @if($data->status == 0)
                            <div class="tp_profile_form_wrapper">
                                <form id="order-status-update-form" action="{{ route('admin.order.update-status') }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 col-lg-6">
                                            <div class="tp_form_wrapper">
                                                <div class="col tp_form_wrapper">
                                                    <label class="mb-2">Status</label>
                                                    <select name="status" class="from-control">
                                                        <option value="0"
                                                            @if ($data->status == 0) selected @endif>
                                                            Pending</option>
                                                        <option value="1"
                                                            @if ($data->status == 1) selected @endif>
                                                            Complete</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <button type="submit" class="btn tp_btn"
                                            id="order-status-update-form-btn">Update</button>
                                    </div>

                                    <input name="id" value="{{ $data->id }}" type="hidden">
                                </form>
                            </div>
                            @endif
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('admin-theme/my_assets/js/form-validate.js') }}"></script>
@endsection
