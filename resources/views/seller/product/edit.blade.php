@extends('layouts.seller_product_edit_add')

@section('content')
    @include('seller.product._header_step_nav')
    <div class="container">
        <div class="body-edit-product">
            <form method="post" enctype="multipart/form-data" id="form-add-product">
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
                            <input type="text" name="name" value="{{ old('name', $product->name) }}"
                                   class="form-control"
                                   placeholder=""
                                   required
                            >
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
                                        $selected = old('category_id', !empty($product->categories) ? $product->categories[0]->id : '') == $categoryId;
                                    @endphp
                                    <option value="{{ $categoryId }}" {{ $selected ? 'selected' : '' }}>{!! str_repeat('&nbsp;', ($level - 1) * 4) !!} {{ $categoryName }}</option>
                                @endforeach
                            </select>
                        </div>
                            <!-- Description -->
                            <div class="detail-form form-group">
                                <label class="gray-name" for="description">@lang('Product Description')</label>
                                <textarea class="form-control" id="description"
                                          name="description"
                                          placeholder="@lang('Type your product description')"
                                          required
                                          rows="12">{{ $product->description }}</textarea>
                            </div>
                        <div class="weight-form">
                            <label><b>@lang('Product Weight & Dimensions')</b></label>
                            <div class="form-group container">
                                <label class="p-gray">@lang('Product Weight')</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" name="weight" value="{{ old('weight', $product->weight) }}"
                                               class="form-control input-option-value"
                                               placeholder="300"
                                               required
                                        >
                                    </div>
                                    <div class="col-3">
                                        <select class="form-control" disabled>
                                            <option value="">Gram</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group container">
                                <label class="p-gray">@lang('Product Dimensions (L x W x H)')</label>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="row d-flex justify-content-between">
                                            <div class="col-4">
                                                <input type="text" name="length" value="{{ old('length', $product->length) }}"
                                                       class="form-control input-option-value"
                                                       placeholder="length"
                                                       required
                                                >
                                            </div>
                                            <div class="col-4">
                                                <input type="text" name="width" value="{{ old('width', $product->width) }}"
                                                       class="form-control input-option-value"
                                                       placeholder="width"
                                                       required
                                                >
                                            </div>
                                            <div class="col-4">
                                                <input type="text" name="height" value="{{ old('height', $product->height) }}"
                                                       class="form-control input-option-value"
                                                       placeholder="height"
                                                       required
                                                >
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-3">
                                        <select class="form-control" disabled>
                                            <option value="">Cm</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 right-edit" style=" padding-left: 80px">
                        <!-- Image 01 -->
                        <div class="row justify-content-around small-row row-add-photo">

                        </div>
                        <div class="details-parameter d-flex justify-content-between">
                            <p>@lang('Add Product Variations')</p>
                            <label class="switch" dusk="check-option-enabled">
                                @php
                                    $isOptionEnabledChecked = old('is_option_enabled', count($product->options) ? '1' : '0');
                                @endphp
                                <input type="checkbox" name="is_option_enabled" class="is-option-enabled"
                                       {{ $isOptionEnabledChecked == 1 ? 'checked' : '' }} value="1">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="row no-gutters wrap-parameter d-none">
                            @foreach($inputOptions as $option)
                            <div class="col-md-6 col-sm-12 parameter pr-2">
                                <div id="detail-parameter">
                                    <p class="p-gray">@lang('Product Variation') {{$loop->iteration}}</p>
                                    <div class="form">
                                        <input type="text" name="options[{{$option['id']}}]"
                                               value="{{ old('options.' . $option['id'], $option['name']) }}"
                                               class="form-control" placeholder="@lang('Color')">

                                        <div class="option-value-holder">
                                            @foreach($option['values'] as $value)
                                                <div class="d-flex">
                                                    <div class=" input-White">
                                                        <input type="text" name="values[{{ $option['id'] }}][{{ $value['id'] }}]"
                                                               value="{{ $value['name'] }}"
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
                                        </div>
                                        <!-- #.option-value-holder -->
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <hr class="hr-body-edit">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 text-left">
                            @php
                                $isBlock = $product->status == \App\Model\Product::STATUS_BLOCK ? true : false;
                            @endphp
                            @if($isBlock)
                                <div class="details-parameter d-flex">
                                    <p style="color: red; font-weight: bold">@lang('The product is locked by admin!')</p>
                                </div>
                            @else
                                <div class="details-parameter d-flex align-items-center">
                                    <p class="mr-2">@lang('Product Visibility')</p>
                                    <label class="switch">
                                        <input type="checkbox" name="is_published"
                                               {{ $product->is_published ? 'checked' : '' }} value="1"
                                                {{ $isBlock ? 'disabled' : ''}}>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8 col-sm-6 text-right">
                            <a class="btn-customer btn-cancel btn" href="{{ route('seller.product.index') }}"
                               role="button" style="max-width: 86px">@lang('Cancel')</a>
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
          var $input = $element.find('input.input-option-value');

          var randomId = -1 * Math.floor(Math.random() * 10000);
          var oldName = $input.attr('name');console.log(oldName);
          var newName = oldName.replace(/values\[(.*?)\]\[(.*?)\]/g, `values[$1][${randomId}]`);

          $input.attr('name', newName);

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

        // Image preview
        $('.input-image-upload').change(function () {
          var self = this;
          var file = $(this)[0].files[0];

          if (!file) {
            $(self).siblings('.img-preview').hide();
            $(self).siblings('.pick-image').show();

            $(self).siblings('.current-image').show();

            return;
          }

          var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

          if (!allowedExtensions.exec(file.name) ) {
            bootoast.toast({
              message: "Please select a valid image file !",
              type: 'danger',
              position: 'rightBottom',
            });

            $(this).val("");

            return;
          }

          if (file.size > 8 * 1024 * 1024) {
            bootoast.toast({
              message: "File too large !",
              type: 'danger',
              position: 'rightBottom',
            });

            $(this).val("");

            return;
          }

          toBase64(file).then(function (base64Content) {
            $(self).siblings('.img-preview').find('img').attr('src', base64Content);
            $(self).siblings('.img-preview').show();
            $(self).siblings('.pick-image').hide();

            $(self).siblings('.current-image').hide();
          });
        });

        // Discount percent
        $('input[name="is_discount_percent"]').change(function () {
          if($(this).is(':checked')) {
            $('#discount-type-text').text(
              $(this).data('true')
            );
          } else {
            $('#discount-type-text').text(
              $(this).data('false')
            );
          }
        });
        $('input[name="is_discount_percent"]').trigger('change');

        // Check quantity empty
        $('input[name="is_quantity_empty"]').change(function () {
          if ($(this).is(':checked')) {
            $('input[name="quantity"]').prop('disabled', true);
          } else {
            $('input[name="quantity"]').prop('disabled', false);
          }
        });
        $('input[name="is_quantity_empty"]').trigger('change');

        // Auto numeric money input.
        $('#price').autoNumeric({
          lZero: 'deny',
          mDec: 0,
          aSep: ','
        });

        $('#quantity').autoNumeric({
          lZero: 'deny',
          mDec: 0,
          aSep: ','
        });

        $('#discount').autoNumeric({
          lZero: 'deny',
          mDec: 0,
          aSep: ','
        });

        function calculateDiscountVal() {
          var discountVal = Number($('#discount').autoNumeric('get'));
          var priceVal = Number($('#price').autoNumeric('get'));

          if (!discountVal || !priceVal) {
            $('#show-discount-holder').hide();
            return;
          }

          // is discount precent
          var discountOnProductVal = discountVal;
          if ($('#is-discount-percent').prop('checked')) {
            discountOnProductVal = priceVal * (discountVal / 100);
          }

          $('#show-discount-val').text(formatNumber(discountOnProductVal));
          $('#show-discount-holder').show();
        }

        $('#discount').keyup(function () {
          calculateDiscountVal();
        });

        $('#price').keyup(function () {
          calculateDiscountVal();
        });

        $('#is-discount-percent').change(function () {
          calculateDiscountVal();
        });

        $('#is-discount-percent').trigger('change');

        $('#form-add-product').validate({
          errorElement: 'div',
          errorClass: 'is-invalid',
          onclick: function (element) {
            console.log('On click');
            if ($(element).attr('name') === 'is_discount_percent') {
              $('input[name="discount"]').valid();
            }
          },
          onkeyup: function (element) {
            if ($(element).attr('name') === 'price' || $(element).attr('name') === 'discount') {
              $('input[name="discount"]').valid();
            }
          },
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
            quantity: {
              required: '#is-quantity-empty:not(:checked)'
            },
            discount: {
              min: {
                param: function () {
                  if ($('#is-discount-percent').prop('checked')) {
                    return 0;
                  }
                    @if(getCurrentCurrencyCode() == 'IDR')
                      return 1000;
                    @else
                      return 0;
                    @endif
                }
              },
              max: {
                param: function () {
                  if ($('#is-discount-percent').prop('checked')) {
                    return 100;
                  }

                  var priceVal = Number($('#price').autoNumeric('get'));

                  return priceVal;
                }
              },
              normalizer: function( value ) {
                return $('#discount').autoNumeric('get');
              },
            },
            price: {
              required: true,
              normalizer: function( value ) {
                return $('#price').autoNumeric('get');
              },
            },
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
          messages: {
            discount: {
                @if(getCurrentCurrencyCode() == 'IDR')
                min: function () {
                  return 'The discount must be at least 1,000 IDR';
                },
                @endif
                max: function () {
                  if ($('#is-discount-percent').prop('checked')) {
                    return 'The discount must not exceed 100%';
                  } else {
                    return 'The discount must not be greater than product price';
                  }

                }
            }
          }
        });
      });
    </script>
@endsection
