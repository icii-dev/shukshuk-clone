@extends('layouts.seller')

@section('content')

    <div class="content content-home-seller">
        <div class="header-sellersHome bg-cover-seller-1">
            <div class="container">
                <div class="row justify-content-between wrap-my-store">
                    <div class="col-md-4 col-sm-8 d-flex my-store">
                        <img src="Img/img-seller-store.png" alt="" class="avatar-seller">
                        <div class="my-store-name">
                            <h3>My Store Name</h3>
                            <a href="#" class="manage-store">@lang('Manage Store') -></a>
                        </div>
                    </div>
                    <div class="col-md-3 col-xl-2 col-sm-6 p-0">
                        <a class="btn-customer primary-icon btn" href="#" role="button">
                            <img src="Img/store.svg">
                            <p>View Store</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom">
        <div class="container">
            @include('seller.shared._main_nav')
        </div>
    </div>
    <div class="container">
        <div class="body-home-seller">
            <div class="row title-home d-flex justify-content-between">
                <h2>Products</h2>
                <div class="col-md-3 col-xl-2 col-sm-8"><a class="btn-customer secondary btn" href="#" role="button">Add New Product</a></div>
            </div>
            <div class="sroll-bar">
                <div class="table table-home-seller">
                    <div class="head">
                        <div class="row detail-home">
                            <div class="col-1">No.</div>
                            <div class="col-3">Product Title</div>
                            <div class="col-4">Product Description</div>
                            <div class="col">Price</div>
                            <div class="col">Stock</div>
                            <div class="col">Actions</div>
                        </div>
                    </div>
                    <hr>
                    <div class="body">
                        <div class="row">
                            <div class="col-1 stt">1</div>
                            <div class="col-3">Honeycomb Tea Signature by Tea...</div>
                            <div class="col-4">Massa egestas elit orci quis a metus vitae diam...</div>
                            <div class="col">Rp 70.000,-</div>
                            <div class="col-1">100</div>
                            <div class="col"><a href="#">View Details -&gt;</a></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-1 stt">1</div>
                            <div class="col-3">Honeycomb Tea Signature by Tea...</div>
                            <div class="col-4">Massa egestas elit orci quis a metus vitae diam...</div>
                            <div class="col">Rp 70.000,-</div>
                            <div class="col-1">100</div>
                            <div class="col"><a href="#">View Details -&gt;</a></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-1 stt">1</div>
                            <div class="col-3">Honeycomb Tea Signature by Tea...</div>
                            <div class="col-4">Massa egestas elit orci quis a metus vitae diam...</div>
                            <div class="col">Rp 70.000,-</div>
                            <div class="col-1">100</div>
                            <div class="col"><a href="#">View Details -&gt;</a></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-1 stt">1</div>
                            <div class="col-3">Honeycomb Tea Signature by Tea...</div>
                            <div class="col-4">Massa egestas elit orci quis a metus vitae diam...</div>
                            <div class="col">Rp 70.000,-</div>
                            <div class="col-1">100</div>
                            <div class="col"><a href="#">View Details -&gt;</a></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-1 stt">1</div>
                            <div class="col-3">Honeycomb Tea Signature by Tea...</div>
                            <div class="col-4">Massa egestas elit orci quis a metus vitae diam...</div>
                            <div class="col">Rp 70.000,-</div>
                            <div class="col-1">100</div>
                            <div class="col"><a href="#">View Details -&gt;</a></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-1 stt">1</div>
                            <div class="col-3">Honeycomb Tea Signature by Tea...</div>
                            <div class="col-4">Massa egestas elit orci quis a metus vitae diam...</div>
                            <div class="col">Rp 70.000,-</div>
                            <div class="col-1">100</div>
                            <div class="col"><a href="#">View Details -&gt;</a></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-1 stt">1</div>
                            <div class="col-3">Honeycomb Tea Signature by Tea...</div>
                            <div class="col-4">Massa egestas elit orci quis a metus vitae diam...</div>
                            <div class="col">Rp 70.000,-</div>
                            <div class="col-1">100</div>
                            <div class="col"><a href="#">View Details -&gt;</a></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-1 stt">1</div>
                            <div class="col-3">Honeycomb Tea Signature by Tea...</div>
                            <div class="col-4">Massa egestas elit orci quis a metus vitae diam...</div>
                            <div class="col">Rp 70.000,-</div>
                            <div class="col-1">100</div>
                            <div class="col"><a href="#">View Details -&gt;</a></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-1 stt">1</div>
                            <div class="col-3">Honeycomb Tea Signature by Tea...</div>
                            <div class="col-4">Massa egestas elit orci quis a metus vitae diam...</div>
                            <div class="col">Rp 70.000,-</div>
                            <div class="col-1">100</div>
                            <div class="col"><a href="#">View Details -&gt;</a></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-1 stt">1</div>
                            <div class="col-3">Honeycomb Tea Signature by Tea...</div>
                            <div class="col-4">Massa egestas elit orci quis a metus vitae diam...</div>
                            <div class="col">Rp 70.000,-</div>
                            <div class="col-1">100</div>
                            <div class="col"><a href="#">View Details -&gt;</a></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-1 stt">1</div>
                            <div class="col-3">Honeycomb Tea Signature by Tea...</div>
                            <div class="col-4">Massa egestas elit orci quis a metus vitae diam...</div>
                            <div class="col">Rp 70.000,-</div>
                            <div class="col-1">100</div>
                            <div class="col"><a href="#">View Details -&gt;</a></div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row justify-content-md-end justify-content-sm-start">
                <div class="col-md-7 col-sm-12 d-flex justify-content-between align-items-center">
                    <p class="color web-block">Page 1 of 4</p>
                    <ul class="pagination justify-content-end">
                        <li class="page-item"><a class="page-link" href="#"><i class="fas fa-arrow-left color-gray" aria-hidden="true"></i></a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item web-block"><a class="page-link" href="#">4</a></li>
                        <li class="page-item web-block"><a class="page-link" href="#">5</a></li>
                        <li class="page-item"><a class="page-link" href="#"><i class="fas fa-arrow-right" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection