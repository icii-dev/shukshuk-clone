@extends('layouts.seller_product_edit_add')

@section('content')
    @include('seller.product._header_step_nav')
    <div class="container">
        <div class="body-edit-product">
            <form method="post" enctype="multipart/form-data" id="form-add-product" novalidate>
                <div class="row">
                    <div class="col-xl-6 col-md-6 col-sm-12" style="padding-right: 80px">

                        @if ($errors->any())
                            <div class="alert alert-danger pb=0">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @csrf
                        <div class="detail-form form-group">
                            <label class="gray-name">@lang('Product Name')</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                                   placeholder="" required>
                        </div>
                        <div class="detail-form form-group">
                            <label class="gray-name" for="category_id">@lang('Product Category')</label>
                            <select name="category_id" id="category_id" class="form-control" required>
                                <option value="">@lang('Choose category')</option>
                                @foreach(getListCategory3Levels() as $category)
                                    @php
                                        $categoryId = $category['id'];
                                        $categoryName = $category['name'];
                                        $level = $category['level'];
                                        $selected = old('category_id') == $categoryId;
                                    @endphp
                                    <option value="{{ $categoryId }}" {{ $selected ? 'selected' : '' }}>
                                        {!! str_repeat('&nbsp;', ($level - 1) * 4) !!} {{ $categoryName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                            <!-- Description -->
                            <div class="detail-form form-group">
                                <label class="gray-name" for="description">@lang('Product Description')</label>
                                <textarea class="form-control" id="description"
                                          name="description" value="{{ old('description') }}"
                                          placeholder="@lang('Type your product description')"
                                          required
                                          rows="12">{{ old('description') }}</textarea>
                            </div>
                            <div class="weight-form">
                                <label><b>@lang('Product Weight & Dimensions')</b></label>
                                <div class="form-group container">
                                    <label class="p-gray">@lang('Product Weight')</label>
                                    <div class="row mt-8px">
                                        <div class="col-8">
                                            <input type="text" name="weight" value="{{ old('weight') }}"
                                                   class="form-control input-option-value"
                                                   placeholder="weight">
                                        </div>
                                        <div class="col-4">
                                            <select class="form-control" disabled>
                                                <option value="">Gram</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group container">
                                    <label class="p-gray">@lang('Product Dimensions (L x W x H)')</label>
                                    <div class="row mt-8px">
                                        <div class="col-8">
                                            <div class="row d-flex justify-content-between">
                                                <div class="col-4">
                                                    <input type="text" name="length" value="{{ old('length') }}"
                                                           class="form-control input-option-value"
                                                           placeholder="@lang('length')">
                                                </div>
                                                <div class="col-4">
                                                    <input type="text" name="width" value="{{ old('width') }}"
                                                           class="form-control input-option-value"
                                                           placeholder="@lang('width')">
                                                </div>
                                                <div class="col-4">
                                                    <input type="text" name="height" value="{{ old('height') }}"
                                                           class="form-control input-option-value"
                                                           placeholder="@lang('height')">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-4">
                                            <select class="form-control" disabled>
                                                <option value="">Cm</option>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="col-md-6 col-sm-12" style="padding-left: 80px" >
                        <div class="details-parameter d-flex justify-content-between">
                            <label><b>@lang('Add Product Variations')</b></label>
                            <label class="switch" dusk="check-option-enabled">
                                @php
                                    $isOptionEnabledChecked = old('is_option_enabled') == 1;
                                @endphp
                                <input type="checkbox" name="is_option_enabled" class="is-option-enabled"
                                       {{ $isOptionEnabledChecked ? 'checked' : '' }} value="1">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="row no-gutters wrap-parameter d-none detail-form">
                            <div id="Parameter-1" class="col-md-6 col-sm-12 parameter pr-2">
                                <div id="detail-parameter" >
                                    <p class="p-gray">@lang('Product Variation') 1</p>
                                    <div class="form">
                                        <input type="text" name="options[0]" value="{{ old('options.0') }}"
                                               class="form-control" placeholder="@lang('Color')">

                                        <!-- .option-value-holder -->
                                        <div class="option-value-holder">
                                            @php
                                                $values = old('values.0', []);
                                            @endphp
                                            @if (!empty($values))
                                                @foreach($values as $value)
                                                    <div class="d-flex">
                                                        <div class=" input-White">
                                                            <input type="text" name="values[0][]" value="{{ $value }}"
                                                                   class="form-control input-option-value"
                                                                   placeholder="">
                                                        </div>
                                                        <div class="remove remove-option-value">
                                                            <img src="{{ asset('asset-seller/Img/minus-circle.svg') }}"
                                                                 alt="">
                                                        </div>
                                                        <div class="add add-option-value">
                                                            <img src="{{ asset('asset-seller/Img/plus-circle.svg') }}"
                                                                 alt="">
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="d-flex">
                                                    <div class=" input-White">
                                                        <input type="text" name="values[0][]"
                                                               class="form-control input-option-value" placeholder="@lang('White')">
                                                    </div>
                                                    <div class="remove remove-option-value">
                                                        <img src="{{ asset('asset-seller/Img/minus-circle.svg') }}"
                                                             alt="">
                                                    </div>
                                                    <div class="add add-option-value">
                                                        <img src="{{ asset('asset-seller/Img/plus-circle.svg') }}"
                                                             alt="">
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <!-- #.option-value-holder -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 parameter pl-2">
                                <p class="p-gray">@lang('Product Variation') 2</p>
                                <input type="text" value="{{ old('options.1') }}" class="form-control" name="options[1]"
                                       placeholder="@lang('Size')">

                                <!-- .option-value-holder -->
                                <div class="option-value-holder">
                                    @php
                                        $values = old('values.1', []);
                                    @endphp
                                    @if (count($values) > 0)
                                        @foreach($values as $value)
                                            <div class="d-flex">
                                                <div class=" input-White">
                                                    <input type="text" name="values[1][]"
                                                           value="{{ $value }}"
                                                           class="form-control input-option-value"
                                                           placeholder="">
                                                </div>
                                                <div class="remove remove-option-value">
                                                    <img src="{{ asset('asset-seller/Img/minus-circle.svg') }}"
                                                         alt="">
                                                </div>
                                                <div class="add add-option-value">
                                                    <img src="{{ asset('asset-seller/Img/plus-circle.svg') }}"
                                                         alt="">
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="d-flex">
                                            <div class=" input-White">
                                                <input type="text" name="values[1][]" value=""
                                                       class="form-control input-option-value" placeholder="@lang('Small')">
                                            </div>
                                            <div class="remove remove-option-value">
                                                <img src="{{ asset('asset-seller/Img/minus-circle.svg') }}"
                                                     alt="">
                                            </div>
                                            <div class="add add-option-value">
                                                <img src="{{ asset('asset-seller/Img/plus-circle.svg') }}"
                                                     alt="">
                                            </div>

                                        </div>
                                    @endif
                                </div>
                                <!-- #.option-value-holder -->
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="hr-body-edit">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 text-left">
                            <div class="details-parameter d-flex">
                                <p>@lang('Product Visibility')</p>
                                <label class="switch ml-2">
                                    <input type="checkbox" name="is_published"
                                           value="1" checked>
                                    <span class="slider round"></span>
                                </label>
                            </div>

                        </div>
                        <div class="col-md-8 col-sm-6 text-right">
                            <a class="btn-customer btn-cancel btn" href="{{ route('seller.product.index') }}"
                               role="button" style="display:inline-block; width: auto">@lang('Cancel')</a>
                            <button type="submit" class="btn-customer secondary btn ml-2" style="width: auto;">@lang('Add product Details')</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('asset-common/js/autoNumeric-min.js') }}"></script>
    <script src="{{ asset('asset-common/js/jquery-validate/jquery.validate.js') }}"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace( 'description');

    </script>
    <script type="text/javascript">
        const createProductUrl = "{!! route('seller.product.create') !!}";
        $(function () {
            $('input.is-option-enabled').change(function () {
                if ($(this).is(':checked')) {
                    $('.wrap-parameter').removeClass('d-none')
                } else {
                    $('.wrap-parameter').addClass('d-none')
                }
            });

            $('input.is-option-enabled').trigger('change');

            $(document).on('click', '.add-option-value', function () {
                var $element = $(this).parent().clone();

                $element.find('.input-option-value').val('');

                $element.insertAfter($(this).parent());
            });

            $(document).on('click', '.remove-option-value', function () {
                if ($(this).parent().siblings().length == 0) {
                    $(this).parent().find('.input-option-value').val('');
                    return;
                }

                $(this).parent().remove();
            });

            $('#form-add-product').validate({
                errorElement: 'div',
                errorClass: 'is-invalid',
                errorPlacement: function (error, element) {
                    var parent = $(element).closest('.form-group');

                    if (parent.length > 0
                        && parent.find('.error-message-holder').length > 0) {
                        error.appendTo(
                            parent.find('.error-message-holder')
                        )
                    } else {
                        error.insertAfter(element);
                    }
                },
                rules: {
                    'values[0][]': {
                        required: function () {
                            return $('input[name="is_option_enabled"]').prop('checked') &&
                                $.trim($('input[name="options[0]"]').val()) !== '';
                        }
                    },
                    'values[1][]': {
                        required: function () {
                            return $('input[name="is_option_enabled"]').prop('checked') &&
                                $.trim($('input[name="options[1]"]').val()) !== '';
                        }
                    }
                },
              // submitHandler: function (form, e) {
              //   e.preventDefault();
              //
              //   $.ajax({
              //     type: 'POST',
              //     data: $(form).serialize(),
              //     contentType: false,
              //     processData: false,
              //     url: createProductUrl,
              //     success: function (resp) {
              //
              //     }
              //   });
              // }
            });
        });
    </script>
@endsection
