<form action="{{route('user-address.create')}}" method="post">
    @csrf
    @foreach(\App\Model\UserAddress::getListType() as $key => $value)
        <label for="type-{{$key}}">
        <input type="radio" name="type" value="{{$key}}" id="type-{{$key}}">{{$value}}
        </label>
        @endforeach

    <input type="text" class="form-control" name="name" placeholder="name">
    <input type="text" class="form-control" name="phone" placeholder="phone">
    <input type="text" class="form-control" name="address" placeholder="address">


    <div class="form-group">
        <div class="wrap-select">
            <select class="selectpicker js-province-picker" title="Province" name="province" style="width:auto;" >
                @foreach(getProvinces() as $provinceId => $provinceName)
                    <option value="{{$provinceId}}">{{$provinceName}}</option>
                @endforeach
            </select>
            <img class="img-select" src="{{ asset("vendor/buyer/Img/arrow-black.svg") }}" alt="">
        </div>
    </div>

    <div class="form-group">
        <div class="wrap-select">
            <select class="selectpicker js-city-picker" title="Cities" id="cities" name="city" style="width:auto;">
                @if(isset($userAddress->province_id))
                    @foreach(App\Model\AddressCity::where('province_id',$userAddress->province_id)->get() as $city)
                        <option value="{{$city->id}}"
                                @if($city->id == $userAddress->regency_id)
                                selected
                                @endif
                        >{{$city->name}}</option>
                    @endforeach
                @endif
            </select>
            <img class="img-select" src="{{ asset("vendor/buyer/Img/arrow-black.svg") }}" alt="">
        </div>
    </div>
    <div class="form-group">
        <div class="wrap-select">
            <select class="selectpicker js-disctrict-picker" title="District" id="districts" name="district" style="width:auto;">
                @if(isset($userAddress->province_id))
                    @foreach(App\Model\AddressDistrict::where('regency_id',$userAddress->regency_id)->get() as $district)
                        <option value="{{$district->id}}"
                                @if($district->id == $userAddress->district_id)
                                selected
                                @endif
                        >{{$district->name}}</option>
                    @endforeach
                @endif
            </select>
            <img class="img-select" src="{{ asset("vendor/buyer/Img/arrow-black.svg") }}" alt="">
        </div>
    </div>

    <button>Submit</button>
</form>

<script>
    $(function () {
        $('.js-province-picker').change(function () {
            // Reset
            $('.js-city-picker').html('');
            $('.js-district-picker').html('');

            var getListCityUrl = "{!! route('address.cities', ['province_id' => '__id__']) !!}";
            var val = $(this).val();

            // Load child
            $.get(getListCityUrl.replace('__id__', val), function (cities) {
                cities.forEach(function (city) {
                    $('.js-city-picker').append(`<option value="${city.id}">${city.name}</option>`);
                });
            });
        });

        $('.js-city-picker').change(function () {
            // Reset
            $('.js-district-picker').html('');

            // Load
            var getListDistrictUrl = "{!! route('address.districts', ['city_id' => '__id__']) !!}";
            var val = $(this).val();

            $.get(getListDistrictUrl.replace('__id__', val), function (disctricts) {
                disctricts.forEach(function (district) {
                    $('.js-district-picker').append(`<option value="${district.id}">${district.name}</option>`);
                });
            });

        });
    });
</script>
