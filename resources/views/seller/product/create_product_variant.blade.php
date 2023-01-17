@extends('layouts.seller_product_edit_add')

@section('content')
    @include('seller.product._header_step_nav')
    @if ($errors->any())
        <div class="alert alert-danger pb=0">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container">
        <div>
            <form method="post" enctype="multipart/form-data" id="form-variant" novalidate>
                @foreach($variants as $variant)
                    <div class="card variant-item mt-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-5 col-md-6 col-sm-12 right-body-edit ">
                                    <div>Product variant {{ $loop->iteration }}</div>
                                    <input type="hidden" name="variants[{{$variant['id']}}][id]" value="{{$variant['id']}}">

                                    @php
                                        $variantModel = isset($variant['model']) ? $variant['model'] : null;
                                    @endphp

                                    @if(Arr::get($variant, 'option_1'))
                                        <div class="detail-form form-group">
                                            <label class="gray-name">{{ Arr::get($variant, 'option_1.option_name') }}</label>
                                            <input type="text" name="name" value="{{ Arr::get($variant, 'option_1.option_value_name') }}" class="form-control"
                                                   placeholder="" disabled>
                                            <input type="hidden" name="variants[{{$variant['id']}}][option_1]" value="{{Arr::get($variant, 'option_1.option_value_id')}}">
                                            <input type="hidden" name="variants[{{$variant['id']}}][options][]" value="{{Arr::get($variant, 'option_1.option_value_id')}}">
                                        </div>
                                    @endif

                                    @if(Arr::get($variant, 'option_2'))
                                        <div class="detail-form form-group">
                                            <label class="gray-name">{{ Arr::get($variant, 'option_2.option_name') }}</label>
                                            <input type="text" name="name" value="{{ Arr::get($variant, 'option_2.option_value_name') }}" class="form-control"
                                                   placeholder="" disabled>
                                            <input type="hidden" name="variants[{{$variant['id']}}][option_2]" value="{{Arr::get($variant, 'option_2.option_value_id')}}">
                                            <input type="hidden" name="variants[{{$variant['id']}}][options][]" value="{{Arr::get($variant, 'option_2.option_value_id')}}">
                                        </div>
                                @endif

                                <!-- Price -->
                                    <div class="detail-form input-date form-group">
                                        <label class="gray-name" for="price">@lang('Product Price')</label>
                                        <div class="form-input-product">
                                            <input type="text" name="variants[{{$variant['id']}}][price]" value="{{ old('variants.' . $variant['id'] . '.price', $variantModel ? $variantModel->price : null) }}" class="form-control price-input"
                                                   required>
                                            <p class="p-gray p-ab">{{ getCurrentCurrencyCode() }}</p>
                                        </div>
                                        <div class="error-message-holder"></div>
                                    </div>
                                    <!-- #Price -->

                                    <!-- Discount -->
                                    <div class="detail-form form-group">
                                        <label class="gray-name" for="discount">@lang('Discount')</label>
                                        <div class="d-flex align-items-center justify-content-between group-check">
                                            <div class="form-input-product">
                                                <input type="text" name="variants[{{$variant['id']}}][discount_value]" class="form-control discount-input"
                                                       value="{{ old('variants.' . $variant['id'] . '.discount_value', $variantModel ? $variantModel->discount_value : null) }}">
                                                <p class="p-gray p-ab discount-type-text">{{ getCurrentCurrencyCode() }}</p>
                                            </div>
                                            <div class="wrap-check" dusk="check-discount-percent">
                                                <label class="custom-control custom-checkbox">
                                                    <input type="checkbox"
                                                           class="custom-control-input is-discount-percent"
                                                           name="variants[{{$variant['id']}}][is_discount_percent]"
                                                           {{ old('variants.' . $variant['id'] . '.is_discount_percent') ? 'checked' : '' }}
                                                           {{ old('variants.' . $variant['id'] . '.is_discount_percent', $variantModel && $variantModel->discount_type == \App\Model\ProductVariant::DISCOUNT_TYPE_PERCENT) ? 'checked' : '' }}
                                                           value="1"
                                                           data-true="%"
                                                           data-false="{{ getCurrentCurrencyCode() }}">
                                                    <span class="custom-control-label"></span>
                                                    <span class="custom-text">@lang('Use Percentage')</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="error-message-holder"></div>
                                        <p style="display: none" class="pt-2 text-muted show-discount-holder"><i>(*) @lang('Discount amount'): <span class="show-discount-val">0</span> {{ getCurrentCurrencyCode() }}</i></p>
                                    </div>
                                    <!-- #Discount -->


                                    <!-- Stock -->
                                    <div class="detail-form form-group ">
                                        <label class="gray-name" for="quantity">@lang('Product Stock')</label>
                                        <div class="d-flex align-items-center justify-content-between group-check">
                                            <div class="form-input-product">
                                                <input type="text" name="variants[{{$variant['id']}}][quantity]" value="{{ old('variants.' . $variant['id'] . '.quantity', $variantModel && $variantModel->quantity >= 0 ? $variantModel->quantity : '') }}"
                                                       class="form-control quantity-input">
                                                <p class="p-gray p-ab">@lang('pcs')</p>
                                            </div>
                                            <div class="wrap-check" dusk="check-quantity-empty">
                                                <label class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="variants[{{$variant['id']}}][is_quantity_empty]"
                                                           {{ old('variants.' . $variant['id'] . '.is_quantity_empty', $variantModel && $variantModel->quantity == -1) ? 'checked' : '' }}
                                                           class="custom-control-input is-quantity-empty"
                                                           value="1">
                                                    <span class="custom-control-label"></span>
                                                    <span class="custom-text">@lang('Set As Empty')</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="error-message-holder"></div>
                                    </div>
                                </div>
                                <!-- #.col-md-5 -->

                                <div class="col-md-6 col-sm-12 right-edit">
                                    <p class="p-gray">
                                        @lang('Product Photos (Max. 4 photos)')
                                    </p>
                                    <div class="row justify-content-around small-row row-add-photo">
                                        <!-- image-01 -->
                                        <div class="col-md-6 col-lg-3 col-sm-6 collap-small mb-1">
                                            <div class="add-photo">
                                                @if ($variantModel && isset($variantModel->images[0]))
                                                    <div class="current-image">
                                                        <input type="hidden" name="images[]" value="{{ $variantModel->images[0] }}">
                                                        <img src="{{ getProductImageUrl($variantModel->images[0]) }}"
                                                             style="max-width: 120px; max-height: 120px; width: inherit; height: inherit;" alt="">
                                                    </div>
                                                @endif
                                                    <div class="pick-image">
                                                        <img class="remove-photo-icon" src="{{ asset('asset-seller/Img/remove-icon.svg') }}" alt="">
                                                        <input class="is-remove-photo" type="hidden" name="isRemovePhotos[{{$variant['id']}}][0]" value="0">
                                                        <label>
                                                            <img class="change-photo-icon" src="{{ asset('asset-seller/Img/camera.svg') }}" alt="">
                                                            <p class="text-center">@lang('Add Photos')</p>
                                                            <input type="file" name="variants[{{$variant['id']}}][images][]" id="photo-0" class="input-image-upload"
                                                                   style="display: none;">
                                                            <input type="hidden" name="variantId" value="{{$variant['id']}}">
                                                            <input type="hidden" name="photoIndex" value="0">
                                                        </label>

                                                    </div>


                                                <div class="img-preview"><img
                                                            style="max-width: 120px; max-height: 120px; width: inherit; height: inherit">
                                                </div>

                                            </div>
                                        </div>
                                        <!-- #image-01 -->

                                        <!-- image-02 -->
                                        <div class="col-md-6 col-lg-3 col-sm-6 collap-small mb-16px">
                                            <div class="add-photo">
                                                @if ($variantModel && isset($variantModel->images[1]))
                                                    <div class="current-image">
                                                        <input type="hidden" name="images[]" value="{{ $variantModel->images[1] }}">
                                                        <img src="{{ getProductImageUrl($variantModel->images[1]) }}"
                                                             style="max-width: 120px; max-height: 120px; width: inherit; height: inherit;" alt="">
                                                    </div>
                                                @endif
                                                    <div class="pick-image">
                                                        <img class="remove-photo-icon" src="{{ asset('asset-seller/Img/remove-icon.svg') }}" alt="">
                                                        <input class="is-remove-photo" type="hidden" name="isRemovePhotos[{{$variant['id']}}][1]" value="0">
                                                        <label>
                                                            <img class="change-photo-icon" src="{{ asset('asset-seller/Img/camera.svg') }}" alt="">
                                                            <p class="text-center">@lang('Add Photos')</p>
                                                            <input type="file" name="variants[{{$variant['id']}}][images][]" id="photo-1" class="input-image-upload"
                                                                   style="display: none;">
                                                            <input type="hidden" name="variantId" value="{{$variant['id']}}">
                                                            <input type="hidden" name="photoIndex" value="1">
                                                        </label>
                                                    </div>
                                                <div class="img-preview"><img
                                                            style="max-width: 120px; max-height: 120px; width: inherit; height: inherit">
                                                </div>

                                            </div>
                                        </div>
                                        <!-- #image-02 -->

                                        <!-- image-03 -->
                                        <div class="col-md-6 col-lg-3 col-sm-6 collap-small">
                                            <div class="add-photo">
                                                @if ($variantModel && isset($variantModel->images[2]))
                                                    <div class="current-image">
                                                        <input type="hidden" name="images[]" value="{{ $variantModel->images[2] }}">
                                                        <img src="{{ getProductImageUrl($variantModel->images[2]) }}"
                                                             style="max-width: 120px; max-height: 120px; width: inherit; height: inherit;" alt="">
                                                    </div>
                                                @endif
                                                    <div class="pick-image">
                                                        <img class="remove-photo-icon" src="{{ asset('asset-seller/Img/remove-icon.svg') }}" alt="">
                                                        <input class="is-remove-photo" type="hidden" name="isRemovePhotos[{{$variant['id']}}][2]" value="0">
                                                        <label>
                                                            <img class="change-photo-icon" src="{{ asset('asset-seller/Img/camera.svg') }}" alt="">
                                                            <p class="text-center">@lang('Add Photos')</p>
                                                            <input type="file" name="variants[{{$variant['id']}}][images][]" id="photo-2" class="input-image-upload"
                                                                   style="display: none;">
                                                            <input type="hidden" name="variantId" value="{{$variant['id']}}">
                                                            <input type="hidden" name="photoIndex" value="2">
                                                        </label>
                                                    </div>
                                                <div class="img-preview"><img
                                                            style="max-width: 120px; max-height: 120px; width: inherit; height: inherit">
                                                </div>
                                                <input type="file" name="variants[{{$variant['id']}}][images][]" id="photo-2" class="input-image-upload"
                                                       style="display: none;">
                                            </div>
                                        </div>
                                        <!-- #image-03 -->

                                        <!-- image-04 -->
                                        <div class="col-md-6 col-lg-3 col-sm-6 collap-small">
                                            <div class="add-photo">
                                                @if ($variantModel && isset($variantModel->images[3]))
                                                    <div class="current-image">
                                                        <input type="hidden" name="images[]" value="{{ $variantModel->images[3] }}">
                                                        <img src="{{ getProductImageUrl($variantModel->images[3]) }}"
                                                             style="max-width: 120px; max-height: 120px; width: inherit; height: inherit;" alt="">
                                                    </div>
                                                @endif
                                                    <div class="pick-image">
                                                        <img class="remove-photo-icon" src="{{ asset('asset-seller/Img/remove-icon.svg') }}" alt="">
                                                        <input class="is-remove-photo" type="hidden" name="isRemovePhotos[{{$variant['id']}}][3]" value="0">
                                                        <label>
                                                            <img class="change-photo-icon" src="{{ asset('asset-seller/Img/camera.svg') }}" alt="">
                                                            <p class="text-center">@lang('Add Photos')</p>
                                                            <input type="file" name="variants[{{$variant['id']}}][images][]" id="photo-3" class="input-image-upload"
                                                                   style="display: none;">
                                                            <input type="hidden" name="variantId" value="{{$variant['id']}}">
                                                            <input type="hidden" name="photoIndex" value="3">
                                                        </label>
                                                    </div>
                                                <div class="img-preview"><img
                                                            style="max-width: 120px; max-height: 120px; width: inherit; height: inherit">
                                                </div>
                                                <input type="file" name="variants[{{$variant['id']}}][images][]" id="photo-3" class="input-image-upload"
                                                       style="display: none;">
                                            </div>
                                        </div>
                                        <!-- #image-04 -->
                                    </div>
                                </div>
                                <!-- #.col-md-6 -->
                            </div>
                            <!-- #.row -->


                        </div>
                        <!-- #.card-body -->
                    </div>
                @endforeach

                <div class="container">
                    <div class="card variant-item mt-4 mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="details-parameter d-flex text-left" style="line-height: 48px">
                                        Total Product Variants: {{ count($variants) }}
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 text-right">
                                    <a class="btn-customer btn-cancel btn" style="width: auto; display: inline-block" href="{{ route('seller.product.edit', ['id' => $product->id]) }}"
                                       role="button">@lang('Back')</a>

                                    <button type="submit" class="btn-customer secondary btn ml-2" style="width: auto; display: inline-block">@lang('Save Product')</button>
                                </div>
                            </div>
                        </div>
                        <!-- #.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('asset-common/js/autoNumeric-min.js') }}"></script>
    <script src="{{ asset('asset-common/js/jquery-validate/jquery.validate.js') }}"></script>
    <script>
        $(function() {
            $('.add-photo').mouseenter(function(){
                $(this).children('.pick-image').css('z-index', 3);
                if($(this).children('.img-preview').find('img').attr('src') != null || $(this).children('.current-image').find('img').attr('src') != null) {
                    $(this).find('p').html('Change Photo');
                    $(this).find('p').css('color', '#fff');
                    $(this).children('.pick-image').find('.change-photo-icon').attr('src', '{{asset('asset-seller/Img/camera_white.svg')}}');
                    $(this).find('.remove-photo-icon').show();
                }
            });
            $('.add-photo').mouseleave(function(){
                $(this).children('.pick-image').css('z-index', 1);
                $(this).find('.remove-photo-icon').hide();
            });
            $('.remove-photo-icon').click(function () {
                let pa = $(this).parents('.add-photo');
                pa.children('.img-preview').find('img').attr('src',null);
                pa.children('.current-image').find('img').attr('src',null);
                pa.find('.input-image-upload').val('');
                pa.find('p').html('Add Photo');
                pa.find('p').css('color', '#4E5662');
                pa.children('.pick-image').find('.change-photo-icon').attr('src', '{{asset('asset-seller/Img/camera.svg')}}');
                pa.children('.pick-image').find('.is-remove-photo').val(1);
                {{--$.ajax({--}}
                {{--    type: 'POST',--}}
                {{--    headers: {--}}
                {{--        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
                {{--    },--}}
                {{--    data: {--}}
                {{--        variantId: pa.find("input[name='variantId']").val(),--}}
                {{--        photoIndex: pa.find("input[name='photoIndex']").val()--}}
                {{--    },--}}
                {{--    url: "{!! route('seller.product.create_product_variants.remove_photo', ['id' => $product->id]) !!}"--}}
                {{--})--}}
                {{--    .done(function (resp) {--}}
                {{--        console.log("removed photo");--}}
                {{--        location.reload();--}}
                {{--    })--}}
                {{--    .fail(function () {--}}

                {{--    })--}}
                {{--    .always(function () {--}}

                {{--    })--}}
            });
        });

    </script>
    <script type="text/javascript">
      const createProductVariantUrl = "{!! route('seller.product.create_product_variants', ['id' => $product->id]) !!}";

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

        // Image preview
        $('.input-image-upload').change(function () {
          var self = this;
          var file = $(this)[0].files[0];
            console.log(
                $(self).val()
            )

          if (!file) {
            $(self).siblings('.img-preview').hide();
            // $(self).siblings('.pick-image').show();

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
              let pa = $(self).parents('.add-photo');
              pa.children('.img-preview').find('img').attr('src', base64Content);
              pa.children('.img-preview').show();
              pa.children('.current-image').hide();

            // $(self).siblings('.img-preview').find('img').attr('src', base64Content);
            // $(self).siblings('.img-preview').show();
            // // $(self).siblings('.pick-image').hide();
            //
            // $(self).siblings('.current-image').hide();
          });
        });

        // Discount percent
        $('input.is-discount-percent').change(function () {
          if($(this).is(':checked')) {
            $(this).closest('.variant-item').find('.discount-type-text').text(
              $(this).data('true')
            );
          } else {
            $(this).closest('.variant-item').find('.discount-type-text').text(
              $(this).data('false')
            );
          }
        });

        $('input.is-discount-percent').trigger('change');

        // Check quantity empty
        $('input.is-quantity-empty').change(function () {
          if ($(this).is(':checked')) {
            $(this).closest('.variant-item').find('.quantity-input').prop('disabled', true);
          } else {
            $(this).closest('.variant-item').find('.quantity-input').prop('disabled', false);
          }
        });

        $('input.is-quantity-empty').trigger('change');

        // Auto numeric money input.
        $('.price-input').autoNumeric({
          lZero: 'deny',
          mDec: 0,
          aSep: ','
        });

        $('.quantity-input').autoNumeric({
          lZero: 'deny',
          mDec: 0,
          aSep: ','
        });

        $('.discount-input').autoNumeric({
          lZero: 'deny',
          mDec: 0,
          aSep: ','
        });

        function calculateDiscountVal($parent) {
          var discountVal = Number($parent.find('.discount-input').autoNumeric('get'));
          var priceVal = Number($parent.find('.price-input').autoNumeric('get'));

          if (!discountVal || !priceVal) {
            $parent.find('.show-discount-holder').hide();
            return;
          }

          // is discount precent
          var discountOnProductVal = discountVal;
          if ($parent.find('.is-discount-percent').prop('checked')) {
            discountOnProductVal = Math.round(priceVal * (discountVal / 100));
          }

          $parent.find('.show-discount-val').text(formatNumber(discountOnProductVal));
          $parent.find('.show-discount-holder').show();
        }

        $('.discount-input').keyup(function () {
          calculateDiscountVal($(this).closest('.variant-item'));
        });

        $('.price-input').keyup(function () {
          calculateDiscountVal($(this).closest('.variant-item'));
        });

        $('.is-discount-percent').change(function () {
          calculateDiscountVal($(this).closest('.variant-item'));
        });

        $('.is-discount-percent').trigger('change');


        $('#form-variant').validate({
          errorElement: 'div',
          errorClass: 'is-invalid',
          onclick: function (element) {
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
            var parent = $(element).closest('.variant-item');

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
          },
          submitHandler: function (form, e) {
              var $form = $(form);

            $form.find('input').each(function(i){
                var self = $(this);
                try{
                  var v = self.autoNumeric('get');
                  self.autoNumeric('destroy');
                  self.val(v);
                }catch(err){
                  console.log("Not an autonumeric field: " + self.attr("name"));
                }
              });

              return true;
          }
          // submitHandler: function (form, e) {
          //   e.preventDefault();
          //
          //   $.ajax({
          //     type: 'POST',
          //     data: new FormData(form),
          //     contentType: false,
          //     processData: false,
          //     url: createProductVariantUrl,
          //     success: function (resp) {
          //
          //     }
          //   });
          //
          //
          //   // $.ajax({
          //   //   type: 'POST',
          //   //   data: new FormData(form),
          //   //   url: createProductVariantUrl
          //   // })
          //   //   .done(function (resp) {
          //   //     console.log(resp);
          //   //   })
          //   //   .fail(function () {
          //   //
          //   //   })
          //   //   .always(function () {
          //   //
          //   //   })
          // }
        });
      });
    </script>
@endsection
