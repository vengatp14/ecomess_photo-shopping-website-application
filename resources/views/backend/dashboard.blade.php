@extends('backend.layouts.app')

@section('content')
@if(auth()->user()->can('smtp_settings') && env('MAIL_USERNAME') == null && env('MAIL_PASSWORD') == null)
    <div class="">
        <div class="alert alert-danger d-flex align-items-center">
            {{translate('Please Configure SMTP Setting to work all email sending functionality')}},
            <a class="alert-link ml-2" href="{{ route('smtp_settings.index') }}">{{ translate('Configure Now') }}</a>
        </div>
    </div>
@endif
@can('admin_dashboard')
<div class="row gutters-16">

    <!-- Customer, Products, Category, Brands -->
    <div class="col-lg-6">
        <div class="row gutters-16">
            <!-- Total Customer -->
            <div class="col-sm-6">
                <div class="dashboard-box bg-white h-220px mb-2rem overflow-hidden">
                    <div class="d-flex flex-column justify-content-between h-100">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h1 class="fs-30 fw-600 text-dark mb-1">
                                    {{ \App\Models\User::where('user_type', 'customer')->where('email_verified_at', '!=', null)->count() }}
                                </h1>
                                <h3 class="fs-13 fw-600 text-secondary mb-0">Total Customer</h3>
                            </div>
                            <div class="mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                                    <path id="Path_41567" data-name="Path 41567" d="M21,13.75a1.25,1.25,0,0,0,2.5,0,7.508,7.508,0,0,0-4.068-6.667,4.375,4.375,0,1,0-6.865,0A7.508,7.508,0,0,0,8.5,13.75a1.25,1.25,0,0,0,2.5,0,5,5,0,0,1,10,0ZM14.125,4.375A1.875,1.875,0,1,1,16,6.25,1.877,1.877,0,0,1,14.125,4.375ZM10.932,24.083a4.375,4.375,0,1,0-6.865,0A7.508,7.508,0,0,0,0,30.75a1.25,1.25,0,0,0,2.5,0,5,5,0,0,1,10,0,1.25,1.25,0,0,0,2.5,0A7.508,7.508,0,0,0,10.932,24.083ZM5.625,21.375A1.875,1.875,0,1,1,7.5,23.25,1.877,1.877,0,0,1,5.625,21.375Zm22.307,2.708a4.375,4.375,0,1,0-6.865,0A7.508,7.508,0,0,0,17,30.75a1.25,1.25,0,0,0,2.5,0,5,5,0,0,1,10,0,1.25,1.25,0,0,0,2.5,0A7.508,7.508,0,0,0,27.932,24.083Zm-5.307-2.708A1.875,1.875,0,1,1,24.5,23.25,1.877,1.877,0,0,1,22.625,21.375Zm0,0" fill="#d5d6db"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="fs-13 fw-600 mb-1">
                                <span class="badge badge-md badge-dot badge-circle badge-danger mr-2"></span>
                                {{ translate('Top Customers') }}
                            </h3>
                            @php
                                $topCustomers = \App\Models\Order::select('users.id', 'users.name', 'users.avatar_original', \DB::raw('COUNT(orders.id) as num_orders'))
                                            ->join('users', 'orders.user_id', '=', 'users.id')
                                            ->groupBy('users.id', 'users.name', 'users.avatar_original')
                                            ->orderByDesc('num_orders')
                                            ->limit(5)
                                            ->get();
                            @endphp
                            @if(count($topCustomers) > 0)
                            <div class="symbol-group">
                                @foreach($topCustomers as $customer)
                                    <div class="symbol size-40px rounded-content overflow-hidden" data-toggle="tooltip" data-title="{{ $customer->name }}">
                                        <img src="{{ uploaded_asset($customer->avatar_original)}}" alt="Customer" class="h-100 img-fit ls-is-cached lazyloaded" onerror="this.onerror=null;this.src='{{ static_asset("assets/img/avatar-place.png") }}';">
                                    </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- Total Products -->
            <div class="col-sm-6">
                <div class="dashboard-box bg-white h-220px mb-2rem overflow-hidden">
                    <div class="d-flex flex-column justify-content-between h-100">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h1 class="fs-30 fw-600 text-dark mb-1">{{ \App\Models\Product::where('published', 1)->count() }}</h1>
                                <h3 class="fs-13 fw-600 text-secondary mb-0">{{ translate('Total Products') }}</h3>
                            </div>
                            <div class="mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="27.429" viewBox="0 0 32 27.429">
                                    <g id="Layer_2" data-name="Layer 2" transform="translate(-2 -4)">
                                        <path id="Path_40719" data-name="Path 40719" d="M32.857,4H3.143A1.143,1.143,0,0,0,2,5.143V12a1.143,1.143,0,0,0,1.143,1.143H4.286V30.286a1.143,1.143,0,0,0,1.143,1.143H30.571a1.143,1.143,0,0,0,1.143-1.143V13.143h1.143A1.143,1.143,0,0,0,34,12V5.143A1.143,1.143,0,0,0,32.857,4ZM29.429,29.143H6.571v-16H29.429Zm2.286-18.286H4.286V6.286H31.714Z" fill="#d5d6dc"></path>
                                        <path id="Path_40720" data-name="Path 40720" d="M13.143,16.286H20A1.143,1.143,0,0,0,20,14H13.143a1.143,1.143,0,0,0,0,2.286Z" transform="translate(1.429 1.429)" fill="#d5d6dc"></path>
                                    </g>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <!-- In-house Products -->
                            <div class="d-flex justify-content-between mb-2">
                                <h3 class="fs-13 fw-600 mb-0 text-truncate mr-2">
                                    <span class="badge badge-md badge-dot badge-circle badge-success mr-2"></span>
                                    {{ translate('In-house Products') }}
                                </h3>
                                <h3 class="fs-13 fw-600 mb-0">
                                    {{ \App\Models\Product::where('published', 1)->where('added_by', 'admin')->count() }}
                                </h3>
                            </div>
                            <!-- Sellers Products -->
                            <div class="d-flex justify-content-between">
                                <h3 class="fs-13 fw-600 text-truncate mr-2">
                                    <span class="badge badge-md badge-dot badge-circle badge-primary mr-2"></span>
                                    {{ translate('Sellers Products') }}
                                </h3>
                                <h3 class="fs-13 fw-600 mb-0">
                                {{ \App\Models\Product::where('published', 1)->where('added_by', 'seller')->count() }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Total Category -->
            <div class="col-sm-6">
                <div class="dashboard-box bg-white h-220px mb-2rem overflow-hidden">
                    <div class="d-flex flex-column justify-content-between h-100">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h1 class="fs-30 fw-600 text-dark mb-1">{{ \App\Models\Category::count() }}</h1>
                                <h3 class="fs-13 fw-600 text-secondary mb-0">{{ translate('Total Category') }}</h3>
                            </div>
                            <div class="mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                                    <path id="_137b5e1009c61a91dc419a2998502736" data-name="137b5e1009c61a91dc419a2998502736" d="M27.144,17.266A4.922,4.922,0,0,1,32,22.207h0v4.836A4.937,4.937,0,0,1,27.144,32H22.407a4.922,4.922,0,0,1-4.841-4.957h0V22.207a4.892,4.892,0,0,1,4.841-4.942h4.737Zm-20.343,0a1.3,1.3,0,0,1,1.247.619,1.358,1.358,0,0,1,0,1.415,1.3,1.3,0,0,1-1.247.619H4.856A2.281,2.281,0,0,0,2.6,22.208h0v4.775a2.326,2.326,0,0,0,2.257,2.289H9.622a2.219,2.219,0,0,0,1.6-.665,2.313,2.313,0,0,0,.662-1.624h0v-7.17l-.02-.178a1.342,1.342,0,0,1,.606-1.19,1.285,1.285,0,0,1,1.462.043,1.348,1.348,0,0,1,.506,1.4h0v7.14a4.907,4.907,0,0,1-4.856,4.957H4.856A5.012,5.012,0,0,1,0,27.028H0v-4.82a4.994,4.994,0,0,1,1.423-3.5,4.791,4.791,0,0,1,3.433-1.442H6.8Zm20.343,2.653H22.407a2.266,2.266,0,0,0-2.242,2.289h0v4.836a2.3,2.3,0,0,0,.652,1.623,2.2,2.2,0,0,0,1.59.666h4.737a2.2,2.2,0,0,0,1.59-.666,2.3,2.3,0,0,0,.652-1.623h0V22.207a2.313,2.313,0,0,0-.657-1.619,2.219,2.219,0,0,0-1.585-.67ZM27.144,0a5.013,5.013,0,0,1,4.841,4.957h0v4.82a5,5,0,0,1-1.376,3.512A4.794,4.794,0,0,1,27.2,14.78h-1.96a1.337,1.337,0,0,1,0-2.653h1.9a2.235,2.235,0,0,0,1.6-.691,2.33,2.33,0,0,0,.645-1.644h0V4.957a2.3,2.3,0,0,0-2.242-2.289H22.407a2.266,2.266,0,0,0-2.242,2.289h0v7.231l-.015.166a1.33,1.33,0,0,1-1.321,1.137,1.28,1.28,0,0,1-.91-.413,1.335,1.335,0,0,1-.352-.951h0V4.957a5,5,0,0,1,1.413-3.5A4.791,4.791,0,0,1,22.407,0h4.737ZM9.593,0a4.922,4.922,0,0,1,4.856,4.957h0V9.793a4.994,4.994,0,0,1-1.423,3.5,4.791,4.791,0,0,1-3.433,1.442H4.856A4.922,4.922,0,0,1,0,9.793H0V4.957A4.937,4.937,0,0,1,4.856,0H9.593Zm0,2.668H4.856a2.218,2.218,0,0,0-1.614.654,2.313,2.313,0,0,0-.672,1.635h0V9.793a2.314,2.314,0,0,0,.656,1.664,2.218,2.218,0,0,0,1.63.67H9.593a2.235,2.235,0,0,0,1.6-.691,2.33,2.33,0,0,0,.645-1.644h0V4.957A2.281,2.281,0,0,0,9.593,2.668Z" fill="#d5d6dc"></path>
                                </svg>
                            </div>
                        </div>
                        <div>                            
                            @php
                                $listCategories = \App\Models\Product::select('products.id AS product_id', 'products.name AS product_name', 'categories.name AS category_name', \DB::raw('SUM(order_details.price * order_details.quantity) AS total_sales_amount'))
                                                ->join('categories', 'products.category_id', '=', 'categories.id')
                                                ->join('order_details', 'products.id', '=', 'order_details.product_id')
                                                ->join('orders', 'order_details.order_id', '=', 'orders.id')
                                                ->whereYear('orders.created_at', '=', now()->year)
                                                ->whereMonth('orders.created_at', '=', now()->month)
                                                ->groupBy('products.id', 'products.name', 'categories.name')
                                                ->limit(3)
                                                ->get();
                            @endphp
                            @if(count($listCategories) > 0)
                                <h3 class="fs-13 fw-600 text-secondary mb-2">{{ translate('Top Categories') }}</h3>
                                <div class="symbol-group">
                                    @foreach($listCategories as $category)
                                        <div class="d-flex justify-content-between mb-1">
                                            <h3 class="fs-13 opacity-60 mb-0 d-flex align-items-center text-truncate mr-2" data-toggle="tooltip" data-title="{{ $category->category_name }}">
                                                <span class="badge badge-sm badge-dot badge-danger mr-2" style="height:4px !important;"></span>
                                                {{ $category->category_name }}
                                            </h3>
                                            <h3 class="fs-13 fw-600 mb-0">
                                                {{ single_price($category->total_sales_amount) }}
                                            </h3>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- Total Brands -->
            <div class="col-sm-6">
                <div class="dashboard-box bg-white h-220px mb-2rem overflow-hidden">
                    <div class="d-flex flex-column justify-content-between h-100">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h1 class="fs-30 fw-600 text-dark mb-1">{{ \App\Models\Brand::count() }}</h1>
                                <h3 class="fs-13 fw-600 text-secondary mb-0">{{ translate('Total Brands') }}</h3>
                            </div>
                            <div class="mt-2">
                                <svg id="Layer_51" data-name="Layer 51" xmlns="http://www.w3.org/2000/svg" width="31.994" height="32" viewBox="0 0 31.994 32">
                                    <path id="Path_41568" data-name="Path 41568" d="M22.534,33.9a3.963,3.963,0,0,1-2.813-1.139L3.175,16.112A4.02,4.02,0,0,1,2.037,12.49L3.175,6.854A3.952,3.952,0,0,1,6.056,3.768l6.377-1.754a4.1,4.1,0,0,1,3.906,1.139L32.783,19.6a4.031,4.031,0,0,1,0,5.694l-7.368,7.47A3.986,3.986,0,0,1,22.534,33.9Zm8.677-12.686L14.722,4.724a1.788,1.788,0,0,0-1.3-.524,1.492,1.492,0,0,0-.444.057L6.592,5.965A1.72,1.72,0,0,0,5.339,7.286L4.257,12.912a1.788,1.788,0,0,0,.49,1.628L21.327,31.1a1.765,1.765,0,0,0,1.207.524,1.663,1.663,0,0,0,1.207-.5l7.5-7.47A1.742,1.742,0,0,0,31.212,21.213Z" transform="translate(-1.966 -1.901)" fill="#d5d6dc"></path>
                                    <path id="Path_41569" data-name="Path 41569" d="M20.246,26A1.139,1.139,0,0,1,18.629,24.4L24.824,18.2a1.139,1.139,0,1,1,1.606,1.617Zm-7.983-9.953a4.316,4.316,0,1,1,4.293-4.339A4.339,4.339,0,0,1,12.263,16.052Zm1.355-6.229a2,2,0,0,0-1.435-.6,1.947,1.947,0,0,0-1.446.569,1.981,1.981,0,0,0-.581,1.412,2.129,2.129,0,0,0,.649,1.435,2.016,2.016,0,0,0,2.847,0,1.925,1.925,0,0,0,.569-1.412,2.027,2.027,0,0,0-.6-1.4Z" transform="translate(-1.557 -1.135)" fill="#d5d6dc"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            @php
                                $listBrands = \App\Models\Product::select('products.id AS product_id', 'products.name AS product_name', 'brands.name AS brand_name', \DB::raw('SUM(order_details.price * order_details.quantity) AS total_sales_amount'))
                                                ->join('brands', 'products.brand_id', '=', 'brands.id')
                                                ->join('order_details', 'products.id', '=', 'order_details.product_id')
                                                ->join('orders', 'order_details.order_id', '=', 'orders.id')
                                                ->whereYear('orders.created_at', '=', now()->year)
                                                ->whereMonth('orders.created_at', '=', now()->month)
                                                ->groupBy('products.id', 'products.name', 'brands.name')
                                                ->limit(3)
                                                ->get();
                            @endphp
                            @if(count($listBrands) > 0)
                                <h3 class="fs-13 fw-600 text-secondary mb-2">{{ translate('Top Brands') }}</h3>
                                <div class="symbol-group">
                                    @foreach($listBrands as $brand)
                                        <div class="d-flex justify-content-between mb-1">
                                            <h3 class="fs-13 opacity-60 mb-0 d-flex align-items-center text-truncate mr-2" data-toggle="tooltip" data-title="{{ $brand->brand_name }}">
                                                <span class="badge badge-md badge-dot badge-circle badge-success mr-2"></span>
                                                {{ $brand->brand_name }}
                                            </h3>
                                            <h3 class="fs-13 fw-600 mb-0">
                                                {{ single_price($brand->total_sales_amount) }}
                                            </h3>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales & sellers -->
    <div class="col-lg-6">
        <div class="row gutters-16">
            @php
                $date = date('Y-m-d');
                $days_ago_30 = date('Y-m-d', strtotime('-30 days', strtotime($date)));
                $days_ago_60 = date('Y-m-d', strtotime('-60 days', strtotime($date)));
                
                $orderTotal = \App\Models\Order::where('payment_status', 'paid')
                    ->where('created_at', '>=', $days_ago_30)
                    ->sum('grand_total');
                $inhouseOrderTotal = \App\Models\Order::where('seller_id', auth()->user()->id)
                    ->where('payment_status', 'paid')
                    ->where('created_at', '>=', $days_ago_30)
                    ->sum('grand_total');

                $sellerOrderTotal = \App\Models\Order::where('seller_id', '!=', auth()->user()->id)
                    ->where('payment_status', 'paid')
                    ->where('created_at', '>=', $days_ago_30)
                    ->sum('grand_total');

                    $totalSalesCount = \App\Models\Order::count();

                    if ($totalSalesCount >= 1000) {
                        $formattedTotalSalesCount = number_format($totalSalesCount / 1000, 1) . 'K';
                    } else {
                        $formattedTotalSalesCount = $totalSalesCount;
                    }
            @endphp
            <!-- Total Sales -->
            <div class="col-sm-6">
                <div class="dashboard-box bg-soft-primary mb-2rem overflow-hidden" style="height: 470px;">
                    <div class="d-flex flex-column justify-content-between h-100"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                        <!-- Total Sales -->
                        <div>
                            <h1 class="fs-30 fw-600 text-primary mb-1">
                                {{ $formattedTotalSalesCount }}
                            </h1>
                            <h3 class="fs-13 fw-600 text-primary mb-0">{{ translate('Total Sales') }}</h3>
                        </div>
                        <!-- Sales this month -->
                        <div class="d-block align-items-center justify-content-between p-3 rounded-2 bg-primary text-white mr-2">
                            <h3 class="fs-13 fw-600">
                                Sales this month
                            </h3>
                            <h3 class="fs-13 fw-600 mb-0">
                                {{ single_price($orderTotal) }}
                            </h3>
                        </div>
                        <!-- Sales Stat -->
                        <div>
                            <h3 class="fs-13 fw-600 text-primary mb-0">Sales Stat</h3>
                        </div>
                        <canvas id="graph-3" class="w-100 chartjs-render-monitor" height="140" width="165" style="display: block; width: 165px; height: 140px;"></canvas>
                        <!-- Sales -->
                        <div>
                            <!-- In-house Sales -->
                            <div class="d-flex justify-content-between mb-1">
                                <h3 class="fs-12 fw-600 mb-0">
                                    <span class="badge badge-md badge-dot badge-circle badge-info text-truncate mr-2"></span>
                                    {{ translate('In-house Sales') }}
                                </h3>
                                <h3 class="fs-13 fw-600 mb-0">
                                    {{ single_price($inhouseOrderTotal) }}
                                </h3>
                            </div>
                            @if (get_setting('vendor_system_activation') == 1)
                            <!-- Sellers Sales -->
                            <div class="d-flex justify-content-between">
                                <h3 class="fs-12 fw-600 mb-0">
                                    <span class="badge badge-md badge-dot badge-circle badge-success text-truncate mr-2"></span>
                                    {{ translate('Sellers Sales') }}
                                </h3>
                                <h3 class="fs-13 fw-600 mb-0">
                                {{ single_price($sellerOrderTotal) }}
                                </h3>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- Total Sellers -->
            @if (get_setting('vendor_system_activation') == 1)
            <div class="col-sm-6">
                <div class="dashboard-box bg-white mb-2rem overflow-hidden" style="height: 470px;">
                    <div class="d-flex flex-column justify-content-between h-100">
                        <!-- Total Sellers -->
                        <div>
                            <h1 class="fs-30 fw-600 text-dark mb-1">
                                {{ \App\Models\Shop::count() }}
                            </h1>
                            <h3 class="fs-13 fw-600 text-secondary mb-0">{{ translate('Total sellers') }}</h3>
                        </div>
                        <!-- Sales -->
                        <div>
                            <div class="d-flex justify-content-between  mb-1 ">
                                <h3 class="fs-13 fw-600 mb-0">
                                    <span class="badge badge-md badge-dot badge-circle badge-success text-truncate mr-2"></span>
                                    {{ translate('Approved Sellers') }}
                                </h3>
                                <h3 class="fs-13 fw-600 mb-0">
                                    {{ \App\Models\Shop::where('verification_status', 1)->count() }}
                                </h3>
                            </div>
                        </div>
                        <!-- Top Sellers -->
                        <div>
                            <h3 class="fs-13 fw-600 mb-1">
                                <span class="badge badge-md badge-dot badge-circle badge-warning mr-2"></span>
                                Top Sellers
                            </h3>
                            
                            @php
                                $topSellers = get_best_sellers(5);
                            @endphp
                            @if(count($topSellers) > 0)
                            <div class="symbol-group">
                                @foreach($topSellers as $seller)
                                    @if ($seller->user != null)
                                    <div class="symbol size-40px rounded-content overflow-hidden" data-toggle="tooltip" data-title="{{ $seller->name }}">
                                        <img src="{{ uploaded_asset($seller->logo) }}" alt="{{ $seller->name }}" class="h-100 img-fit ls-is-cached lazyloaded" onerror="this.onerror=null;this.src='{{ static_asset("assets/img/avatar-place.png") }}';">
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                            @endif
                            <hr style="border: 1px dashed #dbdfe9;">
                        </div>
                        <!-- Sales this month -->
                        <div class="">
                            <a href="{{ route('sellers.index') }}" class="btn btn-md btn-soft-success btn-block rounded-2 mb-3">All Sellers</a>
                            <a href="{{ route('sellers.index',['approved_status' => 0]) }}" class="btn btn-md btn-soft-danger btn-block rounded-2">Pending Sellers</a>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="col-sm-6">
                <div class="dashboard-box bg-white mb-2rem overflow-hidden" style="height: 470px;">
                    <div class="d-flex flex-column align-items-center justify-content-center h-100">
                        <div class="h-200px">
                            <img src="{{ static_asset('assets/img/multivendor.jpg') }}" alt="multivendor" class="h-100 img-fit">
                        </div>
                        <a href="{{route('activation.index')}}" class="mt-4 fs-13 fw-600 text-info hov-text-primary animate-underline-primary">
                            Activate Vendor System
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Orders -->
    <div class="col-lg-6">
        <div class="dashboard-box bg-white mb-2rem overflow-hidden">
            <div class="row gutters-16">
                <!-- Total Orders -->
                <div class="col-sm-6">
                    <div class="dashboard-box bg-soft-info h-lg-300px mb-3 overflow-hidden">
                        <div class="d-flex flex-column justify-content-between h-100">
                            <div>
                                <h1 class="fs-30 fw-600 text-info mb-1">
                                {{ \App\Models\Order::count() }}
                                </h1>
                                <h3 class="fs-13 fw-600 text-secondary mb-0">{{ translate('Total Order') }}</h3>
                            </div>
                            <!-- All Orders button -->

                            <a href="{{ route('all_orders.index') }}" class="btn btn-md btn-info btn-block rounded-2 mt-3">{{ translate('All Orders') }}</a>

                        </div>
                    </div>
                    <!-- Pending order -->
                    <div class="bg-danger rounded-2 h-90px d-flex align-items-center justify-content-between text-white px-2rem mb-3 mb-sm-0">
                        <div class="d-flex flex-wrap align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="mr-3" viewBox="0 0 20 20">
                                <g id="_5" data-name="5" transform="translate(-2 -2)">
                                    <path id="Path_41562" data-name="Path 41562" d="M12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z" fill="#fff"></path>
                                    <path id="Path_41563" data-name="Path 41563" d="M12,6a1,1,0,0,0-1,1v4.59l-2.71,2.7A1,1,0,1,0,9.7,15.7l3-3A1,1,0,0,0,13,12V7A1,1,0,0,0,12,6Z" fill="#fff"></path>
                                </g>
                            </svg>
                            <p class="fs-13 fw-600 mb-0">{{ translate('Pending order') }}</p>
                        </div>
                        <h1 class="fs-24 fw-600 mb-0">
                        {{ \App\Models\Order::where('delivery_status', 'pending')->count() }}
                        </h1>
                    </div>
                </div>

                <div class="col-sm-6">
                    <!-- Order Placed -->
                    <div class="bg-soft-primary rounded-2 h-90px d-flex align-items-center justify-content-between text-primary px-2rem mb-3">
                        <div class="d-flex flex-wrap align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="23.999" height="23.999" class="mr-3" viewBox="0 0 23.999 23.999">
                                <g id="Group_29223" data-name="Group 29223" transform="translate(-2.25 -2.25)">
                                    <path id="Path_18961" data-name="Path 18961" d="M22.071,26.249H6.436A4.186,4.186,0,0,1,2.25,22.063V6.428A4.186,4.186,0,0,1,6.436,2.25H22.071a4.178,4.178,0,0,1,4.178,4.178V22.063a4.186,4.186,0,0,1-4.178,4.186ZM6.436,4.217A2.211,2.211,0,0,0,4.217,6.428V22.063a2.219,2.219,0,0,0,2.219,2.219H22.071a2.211,2.211,0,0,0,2.211-2.219V6.428a2.211,2.211,0,0,0-2.211-2.211Z" fill="#009ef7"></path>
                                    <path id="Path_18962" data-name="Path 18962" d="M12.5,15.233a1.9,1.9,0,0,1-.787-.173,1.959,1.959,0,0,1-1.149-1.8V3.234a.984.984,0,1,1,1.967,0V13.258l1.849-1.637a1.9,1.9,0,0,1,2.526,0l1.9,1.645L18.743,3.234a.984.984,0,0,1,1.967,0V13.258a1.959,1.959,0,0,1-1.149,1.8,1.9,1.9,0,0,1-2.054-.307l-1.873-1.621-1.873,1.629a1.9,1.9,0,0,1-1.259.472ZM15.6,13.109ZM15.674,13.109Zm1.141,8.278H9.734a.984.984,0,1,1,0-1.967h7.082a.984.984,0,1,1,0,1.967Z" transform="translate(-1.385)" fill="#009ef7"></path>
                                </g>
                            </svg>
                            <p class="fs-13 fw-600 text-dark mb-0">{{ translate('Order Placed') }}</p>
                        </div>
                        <h1 class="fs-24 fw-600 mb-0">
                            {{ \App\Models\Order::count() }}
                        </h1>
                    </div>
                    <!-- Confirmed Order -->
                    <div class="bg-soft-success rounded-2 h-90px d-flex align-items-center justify-content-between text-success px-2rem mb-3">
                        <div class="d-flex flex-wrap align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="23.999" height="25.134" class="mr-3" viewBox="0 0 23.999 25.134">
                                <g id="Group_29224" data-name="Group 29224" transform="translate(-41.293 -19.076)">
                                    <path id="Path_18953" data-name="Path 18953" d="M63.758,20.966V39.321c0,.054,0,.11-.008.163.01-.069.018-.135.028-.2a1.214,1.214,0,0,1-.082.3l.076-.184a1.7,1.7,0,0,1-.1.176c-.061.1.112-.122.051-.061-.023.023-.043.051-.066.074s-.041.038-.061.056c-.092.089.161-.1.048-.038-.059.033-.115.069-.176.1l.184-.076a1.184,1.184,0,0,1-.3.082l.2-.028a5.439,5.439,0,0,1-.576.008H58.56l.66,1.15a6.862,6.862,0,1,0-12.035-6.582,7.037,7.037,0,0,0-.732,2.656,6.91,6.91,0,0,0,.579,3.25,6.391,6.391,0,0,0,.339.673l.66-1.15H43.715c-.227,0-.464.015-.691-.008l.2.028a1.214,1.214,0,0,1-.3-.082l.184.076a1.7,1.7,0,0,1-.176-.1c-.1-.061.122.112.061.051-.023-.023-.051-.043-.074-.066s-.038-.041-.056-.061c-.089-.092.1.161.038.048-.033-.059-.069-.115-.1-.176l.076.184a1.214,1.214,0,0,1-.082-.3c.01.069.018.135.028.2a5.309,5.309,0,0,1-.008-.6V20.989c0-.054,0-.11.008-.163-.01.069-.018.135-.028.2a1.215,1.215,0,0,1,.082-.3l-.076.184a1.7,1.7,0,0,1,.1-.176c.061-.1-.112.122-.051.061.023-.023.043-.051.066-.074s.041-.038.061-.056c.092-.089-.161.1-.048.038.059-.033.115-.069.176-.1l-.184.076a1.184,1.184,0,0,1,.3-.082l-.2.028a6.185,6.185,0,0,1,.653-.008H63.4c.056,0,.11,0,.166.008l-.2-.028a1.215,1.215,0,0,1,.3.082l-.184-.076a1.7,1.7,0,0,1,.176.1c.1.061-.122-.112-.061-.051.023.023.051.043.074.066s.038.041.056.061c.089.092-.1-.161-.038-.048.033.059.069.115.1.176l-.076-.184a1.184,1.184,0,0,1,.082.3c-.01-.069-.018-.135-.028-.2,0,.051.005.1.008.143a.765.765,0,0,0,1.53,0A1.893,1.893,0,0,0,63.419,19.1H43.264a2.074,2.074,0,0,0-1.01.237A1.9,1.9,0,0,0,41.3,21V38.712a3.559,3.559,0,0,0,.1,1.242,1.915,1.915,0,0,0,1.216,1.175,2.017,2.017,0,0,0,.63.082h4.78a.772.772,0,0,0,.66-1.15,6.534,6.534,0,0,1-.349-.693l.076.184a6.2,6.2,0,0,1-.428-1.565c.01.069.018.135.028.2a6.223,6.223,0,0,1,0-1.629c-.01.069-.018.135-.028.2a6.2,6.2,0,0,1,.423-1.553l-.076.184a6.186,6.186,0,0,1,.413-.808c.079-.127.161-.255.25-.377l.069-.094c.01-.013.02-.025.031-.041.043-.061-.071.1-.069.089.013-.056.11-.135.148-.181a5.992,5.992,0,0,1,.63-.642c.054-.048.11-.094.166-.14l.092-.074c.087-.071-.158.117-.036.028s.245-.176.37-.257a6.1,6.1,0,0,1,.92-.484l-.184.076a6.173,6.173,0,0,1,1.553-.423l-.2.028a6.2,6.2,0,0,1,1.626,0l-.2-.028a6.2,6.2,0,0,1,1.553.423l-.184-.076a6.186,6.186,0,0,1,.808.413c.127.079.255.161.377.25l.094.069c.013.01.025.02.041.031.061.043-.1-.071-.089-.069.056.013.135.11.181.148a5.991,5.991,0,0,1,.642.63c.048.054.094.11.14.166.025.031.048.061.074.092.071.087-.117-.158-.028-.036s.176.245.257.37a6.1,6.1,0,0,1,.484.92l-.076-.184a6.173,6.173,0,0,1,.423,1.553c-.01-.069-.018-.135-.028-.2a6.335,6.335,0,0,1,0,1.629c.01-.069.018-.135.028-.2a6.171,6.171,0,0,1-.428,1.565l.076-.184a6.534,6.534,0,0,1-.349.693.771.771,0,0,0,.66,1.15h2.33c.841,0,1.68.008,2.521,0a1.891,1.891,0,0,0,1.879-1.866V20.966a.767.767,0,0,0-1.535,0Z" transform="translate(0 -0.023)" fill="#4fcc89"></path>
                                    <path id="Path_18954" data-name="Path 18954" d="M251.777,19.842v6.939l1.15-.66-2.506-1.313c-.107-.056-.217-.117-.326-.171a.844.844,0,0,0-.806.015c-.056.031-.115.059-.171.089-.482.252-.966.5-1.448.76l-1.18.619,1.15.66V19.842l-.765.765h5.665a.765.765,0,0,0,0-1.53h-5.665a.775.775,0,0,0-.765.765v6.939a.773.773,0,0,0,1.15.66l2.475-1.3c.12-.061.237-.125.357-.186h-.772l2.475,1.3c.12.061.237.125.357.186a.773.773,0,0,0,1.15-.66V19.842a.762.762,0,1,0-1.524,0Zm3.263,17.506a6.233,6.233,0,0,1-.054.816c.01-.069.018-.135.028-.2a6.171,6.171,0,0,1-.428,1.565l.076-.184a6.214,6.214,0,0,1-.607,1.1c-.048.071-.1.138-.15.209.148-.209.043-.056.005-.01s-.061.076-.094.112c-.12.14-.245.275-.375.4s-.268.252-.41.367l-.115.092c.2-.163.056-.043.008-.008-.069.051-.14.1-.212.148a6.1,6.1,0,0,1-1.007.546l.184-.076a6.152,6.152,0,0,1-1.563.428l.2-.028a6.262,6.262,0,0,1-1.634,0l.2.028a6.152,6.152,0,0,1-1.563-.428l.184.076a6,6,0,0,1-1.007-.546c-.071-.048-.143-.1-.212-.148-.046-.036-.191-.156.008.008l-.115-.092c-.143-.117-.278-.24-.41-.367s-.255-.263-.375-.4c-.031-.038-.064-.074-.094-.112s-.143-.2.005.01c-.048-.069-.1-.138-.15-.209a6.213,6.213,0,0,1-.607-1.1l.076.184a6.2,6.2,0,0,1-.428-1.565c.01.069.018.135.028.2a6.223,6.223,0,0,1,0-1.629c-.01.069-.018.135-.028.2a6.2,6.2,0,0,1,.423-1.553l-.076.184a6.184,6.184,0,0,1,.413-.808c.079-.127.161-.255.25-.377l.069-.094c.01-.013.02-.025.031-.041.043-.061-.071.1-.069.089.013-.056.11-.135.148-.181a5.992,5.992,0,0,1,.63-.642c.054-.048.11-.094.166-.14l.092-.074c.087-.071-.158.117-.036.028s.245-.176.37-.257a6.1,6.1,0,0,1,.92-.484l-.184.076a6.173,6.173,0,0,1,1.553-.423l-.2.028a6.2,6.2,0,0,1,1.626,0l-.2-.028a6.2,6.2,0,0,1,1.553.423l-.184-.076a6.186,6.186,0,0,1,.808.413c.127.079.255.161.377.25l.094.069c.013.01.025.02.041.031.061.043-.1-.071-.089-.069.056.013.135.11.181.148a5.993,5.993,0,0,1,.642.63c.048.054.094.11.14.166.025.031.048.061.074.092.071.087-.117-.158-.028-.036s.176.245.257.37a6.1,6.1,0,0,1,.484.92l-.076-.184a6.173,6.173,0,0,1,.423,1.553c-.01-.069-.018-.135-.028-.2.023.27.041.54.041.813a.765.765,0,1,0,1.53,0,6.848,6.848,0,0,0-3.939-6.205,6.727,6.727,0,0,0-1.853-.566,7.4,7.4,0,0,0-2.187.008,6.849,6.849,0,0,0-5.264,9.269,7.23,7.23,0,0,0,1.219,2.009,6.833,6.833,0,0,0,5.713,2.322,6.985,6.985,0,0,0,3.995-1.7,6.788,6.788,0,0,0,2.19-3.832,7.471,7.471,0,0,0,.127-1.305.765.765,0,0,0-1.53,0Z" transform="translate(-196.417)" fill="#4fcc89"></path>
                                    <path id="Path_18955" data-name="Path 18955" d="M359.965,640l1.706,1.706.242.242a.774.774,0,0,0,1.081,0l1.366-1.366,2.177-2.177.5-.5a.764.764,0,1,0-1.081-1.081l-1.366,1.366-2.177,2.177-.5.5h1.081l-1.706-1.706-.242-.242A.764.764,0,0,0,359.965,640Z" transform="translate(-310.336 -601.79)" fill="#4fcc89"></path>
                                </g>
                            </svg>
                            <span class="fs-13 fw-600 text-dark mb-0">{{ translate('Confirmed Order') }}</span>
                        </div>
                        <h1 class="fs-24 fw-600 mb-0">
                            {{ \App\Models\Order::where('delivery_status', 'confirmed')->count() }}
                        </h1>
                    </div>
                    <!-- Processed Order -->
                    <div class="bg-soft-danger rounded-2 h-90px d-flex align-items-center justify-content-between text-danger px-2rem mb-3">
                        <div class="d-flex flex-wrap align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="26.182" class="mr-3" viewBox="0 0 24 26.182">
                                <path id="Path_18963" data-name="Path 18963" d="M16,0,4,5.455V20.727l12,5.455,12-5.455V5.455Zm0,2.4,8.045,3.657L16,9.712,7.952,6.055ZM6.182,19.323V7.645l8.727,3.965V23.288Zm19.636,0-8.727,3.966V11.61l8.727-3.966Z" transform="translate(-4)" fill="#f1416c"></path>
                            </svg>
                            <span class="fs-13 fw-600 text-dark mb-0">{{ translate('Processed Order') }}</span>
                        </div>
                        <h1 class="fs-24 fw-600 mb-0">
                            {{ \App\Models\Order::where('delivery_status', 'picked_up')->count() }}
                        </h1>
                    </div>
                    <!-- Order Shipped -->
                    <div class="bg-soft-warning rounded-2 h-90px d-flex align-items-center justify-content-between text-warning px-2rem">
                        <div class="d-flex flex-wrap align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="20.727" class="mr-3" viewBox="0 0 24 20.727">
                                <path id="shipping-truck" d="M25,13.409v5.455a1.091,1.091,0,0,1-1.091,1.091H22.818a3.273,3.273,0,1,1-6.545,0H9.727a3.273,3.273,0,1,1-6.545,0H2.091A1.091,1.091,0,0,1,1,18.864V5.773A3.273,3.273,0,0,1,4.273,2.5h9.818a3.273,3.273,0,0,1,3.273,3.273V7.955h2.182a3.273,3.273,0,0,1,2.618,1.309l2.618,3.491a.665.665,0,0,1,.076.153l.065.12A1.091,1.091,0,0,1,25,13.409ZM7.545,19.955a1.091,1.091,0,1,0-1.091,1.091A1.091,1.091,0,0,0,7.545,19.955ZM15.182,5.773a1.091,1.091,0,0,0-1.091-1.091H4.273A1.091,1.091,0,0,0,3.182,5.773v12h.851a3.273,3.273,0,0,1,4.844,0h6.305Zm2.182,6.545h4.364l-1.309-1.745a1.091,1.091,0,0,0-.873-.436H17.364Zm3.273,7.636a1.091,1.091,0,1,0-1.091,1.091A1.091,1.091,0,0,0,20.636,19.955ZM22.818,14.5H17.364v3.033a3.273,3.273,0,0,1,4.6.24h.851Z" transform="translate(-1 -2.5)" fill="#ffc700"></path>
                            </svg>
                            <span class="fs-13 fw-600 text-dark mb-0">{{ translate('Order Shipped') }}</span>
                        </div>
                        <h1 class="fs-24 fw-600 mb-0">
                            {{ \App\Models\Order::where('delivery_status', 'on_the_way')->count() }}
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>            

    <!-- Top Category & Top Brands -->
    <div class="col-lg-6">
        <div class="row gutters-16">
            <!-- Top Category -->
            <div class="col-sm-6">
                <div class="dashboard-box bg-white px-0 mb-2rem overflow-hidden" style="height: 474px;">
                    <div class="mb-2 px-2rem">
                        <h2 class="fs-16 fw-600 text-primary mb-1 h-40px">{{ translate('In-house Top Category') }}
                        </h2>
                        <h4 class="fs-13 fw-600 text-secondary mb-0">{{ translate('By Sales') }}</h4>
                    </div>
                    <!-- nav -->
                    <ul class="nav nav-tabs dashboard-tab dashboard-tab-primary border-0 px-2rem mb-3" role="tablist" aria-orientation="vertical">
                        <li class="nav-item">
                            <a class="nav-link active inhouse_top_categories" id="all-tab" href="#all" data-toggle="tab" data-target="all" type="button" role="tab" aria-controls="all" aria-selected="true">
                                All
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link inhouse_top_categories" id="today-tab" href="#today" data-toggle="tab" data-target="DAY" type="button" role="tab" aria-controls="today" aria-selected="true">
                                Today
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link inhouse_top_categories" id="week-tab" href="#week" data-toggle="tab" data-target="WEEK" type="button" role="tab" aria-controls="week" aria-selected="true">
                                Week
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link inhouse_top_categories" id="month-tab" href="#month" data-toggle="tab" data-target="MONTH" type="button" role="tab" aria-controls="month" aria-selected="true">
                                Month
                            </a>
                        </li>
                    </ul>
                    <!-- Categories -->
                    <div class="h-290px h-lg-280px h-xxl-300px c-scrollbar-light px-2rem mt-4" style="overflow-x: hidden;" id="inhouse-top-categories"> </div>   
                </div>
            </div>

            <!-- Top Brands -->
            <div class="col-sm-6">
                <div class="dashboard-box bg-white px-0 mb-2rem overflow-hidden" style="height: 474px;">
                    <div class="mb-2 px-2rem">
                        <h2 class="fs-16 fw-600 text-danger mb-1 h-40px">{{ translate('In-house Top Brands') }}</h2>
                        <h4 class="fs-13 fw-600 text-secondary mb-0">{{ translate('By Sales') }}</h4>
                    </div>
                    <!-- nav -->
                    <ul class="nav nav-tabs dashboard-tab dashboard-tab-danger border-0 px-2rem mb-3" role="tablist" aria-orientation="vertical">
                        <li class="nav-item">
                            <a class="nav-link active inhouse_top_brands" id="all-tab" href="#all" data-toggle="tab" data-target="all" type="button" role="tab" aria-controls="all" aria-selected="true">
                                All
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link inhouse_top_brands" id="today-tab" href="#today" data-toggle="tab" data-target="DAY" type="button" role="tab" aria-controls="today" aria-selected="true">
                                Today
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link inhouse_top_brands" id="week-tab" href="#week" data-toggle="tab" data-target="WEEK" type="button" role="tab" aria-controls="week" aria-selected="true">
                                Week
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link inhouse_top_brands" id="month-tab" href="#month" data-toggle="tab" data-target="MONTH" type="button" role="tab" aria-controls="month" aria-selected="true">
                                Month
                            </a>
                        </li>
                    </ul>
                    <!-- Brands -->
                    <div class="h-290px h-lg-280px h-xxl-300px c-scrollbar-light px-2rem mt-4" style="overflow-x: hidden;" id="inhouse-top-brands">
                    
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- In-house Store -->
    <div class="col-lg-6">
        <div class="dashboard-box bg-white mb-2rem overflow-hidden">
            <div class="row gutters-16">
                <!-- In-house Store -->
                <div class="col-sm-6 d-flex flex-column justify-content-between"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                    <!-- Total In-house Sales -->
                    <div>
                        <h2 class="fs-16 fw-600 text-dark mb-2rem">{{ translate('In-house Store') }}</h2>
                        <h1 class="fs-30 fw-600 text-dark mb-1">
                            {{ single_price(\App\Models\Order::where('seller_id', auth()->user()->id)->where('payment_status', 'paid')->sum('grand_total')) }}
                        </h1>
                        <h4 class="fs-13 fw-600 text-dark text-secondary mb-0">Total Sales</h4>
                    </div>
                    <!-- Order graph -->
                    <canvas id="graph-2" class="w-100 h-auto chartjs-render-monitor" height="201" width="198" style="display: block; width: 198px; height: 201px;"></canvas>
                    <!-- All In-house Orders -->
                    <a href="{{ route('inhouse_orders.index') }}" class="btn btn-md btn-soft-info btn-block rounded-2 mt-4 mb-4 mt-sm-0 mb-sm-0">{{ translate('All In-house Orders') }}</a>
                </div>

                <div class="col-sm-6">
                    <!-- In-house product -->
                    <div class="bg-soft-secondary rounded-2 h-120px d-flex flex-column justify-content-center text-primary px-2rem mb-4">
                        <h1 class="fs-30 fw-600 text-dark mb-0">
                            {{ \App\Models\Product::where('published', 1)->where('added_by', 'admin')->count() }}
                        </h1>
                        <p class="fs-13 fw-600 text-primary mb-0">{{ translate('Inhouse product') }}</p>
                    </div>
                    <!-- Ratings -->
                    <div class="bg-soft-secondary rounded-2 h-120px d-flex flex-column justify-content-center text-success px-2rem mb-4">
                        <h1 class="fs-30 fw-600 text-dark mb-0">
                            {{ \App\Models\Order::select(DB::raw('SUM(products.rating) AS total_rating'))
                                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                                ->join('products', 'order_details.product_id', '=', 'products.id')
                                ->first()->total_rating }}
                        </h1>
                        <p class="fs-13 fw-600 text-warning mb-0">{{ translate('Ratings') }}</p>
                    </div>
                    <!-- Total Orders -->
                    <div class="bg-soft-secondary rounded-2 h-120px d-flex flex-column justify-content-center text-danger px-2rem">
                        <h1 class="fs-30 fw-600 text-dark mb-0">
                        {{ \App\Models\Order::where('seller_id', auth()->user()->id)->count() }}
                        </h1>
                        <p class="fs-13 fw-600 text-info mb-0">{{ translate('Total orders') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endcan


@endsection
@section('script')
    <script type="text/javascript">
        AIZ.plugins.chart('#graph-3', {
            type: 'line',
            data: {
                labels: [
                                    ],
                datasets: [{
                        fill: false,
                        borderColor: '#009ef7',
                        label: 'Yearly Sales',
                        data: [
                                                    ],

                    },

                ]
            },
            options: {
                legend: {
                    labels: {
                        fontFamily: 'sans-serif',
                        fontColor: "#000",
                        boxWidth: 10,
                        usePointStyle: true
                    },
                    onClick: function() {
                        return '';
                    },
                    position: 'bottom'
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false,
                        },
                        ticks: {
                            display: false
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: false,
                        },
                        ticks: {
                            display: false
                        }
                    }],
                }
            }
        });

        AIZ.plugins.chart('#graph-2', {
            type: 'doughnut',
            data: {
                labels: [
                                            "Cash On Delivery",
                                            "Others",
                                            "Wallet",
                                    ],
                datasets: [{
                    label: 'My First Dataset',
                    data: [
                        "{{ single_price(\App\Models\Order::where('seller_id', auth()->user()->id)->where('payment_status', 'paid')->where('payment_type', 'cash_on_delivery')->sum('grand_total')) }}",
                        "{{ single_price(\App\Models\Order::where('seller_id', auth()->user()->id)->where('payment_status', 'paid')->where('payment_type', 'wallet')->sum('grand_total')) }}",
                        "{{ single_price(\App\Models\Order::where('seller_id', auth()->user()->id)->where('payment_status', 'paid')->where('payment_type', '!=','wallet')->where('payment_type', '!=','cash_on_delivery')->sum('grand_total')) }}",
                    ],
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                legend: {
                    position: 'bottom',
                    align: 'center',
                    labels: {
                        usePointStyle: true,
                        fontSize: 11,
                        boxWidth: 30
                    },
                },
            }
        })

        function top_category_products(category_id, e) {
            $(".top_category_products").removeClass("active");
            e.classList.add("active");
            $(".top_category_product_table").removeClass("show");
            $("#top_category_product_table_" + category_id).addClass("show");
        }

        function top_sellers_products(seller_id, e) {
            $(".top_sellers_products").removeClass("active");
            e.classList.add("active");
            $(".top_sellers_product_table").removeClass("show");
            $("#top_sellers_product_table_" + seller_id).addClass("show");
        }

        function top_brands_products(brand_id, e) {
            $(".top_brands_products").removeClass("active");
            e.classList.add("active");
            $(".top_brands_product_table").removeClass("show");
            $("#top_brands_product_table_" + brand_id).addClass("show");
        }
    </script>

    <script type="text/javascript">
        
        $('.dropdown-menu a[data-toggle="tab"]').click(function(e) {
            e.stopPropagation()
            $(this).tab('show')
        })

        function menuSearch() {
            var filter, item;
            filter = $("#menu-search").val().toUpperCase();
            items = $("#main-menu").find("a");
            items = items.filter(function(i, item) {
                if ($(item).find(".aiz-side-nav-text")[0].innerText.toUpperCase().indexOf(filter) > -1 && $(item)
                    .attr('href') !== '#') {
                    return item;
                }
            });

            if (filter !== '') {
                $("#main-menu").addClass('d-none');
                $("#search-menu").html('')
                if (items.length > 0) {
                    for (i = 0; i < items.length; i++) {
                        const text = $(items[i]).find(".aiz-side-nav-text")[0].innerText;
                        const link = $(items[i]).attr('href');
                        $("#search-menu").append(
                            `<li class="aiz-side-nav-item"><a href="${link}" class="aiz-side-nav-link"><i class="las la-ellipsis-h aiz-side-nav-icon"></i><span>${text}</span></a></li`
                            );
                    }
                } else {
                    $("#search-menu").html(
                        `<li class="aiz-side-nav-item"><span	class="text-center text-muted d-block">Nothing found</span></li>`
                        );
                }
            } else {
                $("#main-menu").removeClass('d-none');
                $("#search-menu").html('')
            }
        }
    </script>
@endsection
