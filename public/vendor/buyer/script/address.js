function getCitiesOfProvince(province_id){
    $.ajax({
        type: 'GET',
        url: config.routes.cities+province_id,
        async: false,
        beforeSend: function (xhr) {
            if (xhr && xhr.overrideMimeType) {
                xhr.overrideMimeType('application/json;charset=utf-8');
            }
        },
        dataType: 'json',
        success: function (data) {
            let optionsCities = "";
            $.each( data, function( key, value ) {
                console.log(value);
                optionsCities += "<option class='cities-options' value=\""+value.id+"\">"+value.name+"</option>";
            });
            $('#cities').html(optionsCities).selectpicker('refresh').trigger('change');
        }
    });
}
function getDistrictOfCity(city_id){
    $.ajax({
        type: 'GET',
        url: config.routes.districts+city_id,
        async: false,
        beforeSend: function (xhr) {
            if (xhr && xhr.overrideMimeType) {
                xhr.overrideMimeType('application/json;charset=utf-8');
            }
        },
        dataType: 'json',
        success: function (data) {
            let optionsDistrict = "";
            $.each( data, function( key, value ) {
                console.log(value);
                optionsDistrict += "<option class='district-options' value=\""+value.id+"\">"+value.name+"</option>";
            });
            $('#districts').html(optionsDistrict).selectpicker('refresh');
        }
    });
}