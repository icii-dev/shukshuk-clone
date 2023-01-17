<form class="row wrap-filter" action="{{$filterAction}}" id="getProducts">
<div class="col-3">
    <div class="wrap-select">
        <select class="selectpicker" title="Category" name="cat" required>
            @foreach(getListCategoryParent() as $cat)
                <option value="{{$cat->slug}}" >
                    {{$cat->name}}
                </option>
            @endforeach
        </select>
        <img class="img-select" src="{{ asset("vendor/buyer/Img/arrow-black.svg") }}" alt="">
    </div>
</div>
<div class="col-3">
    <div class="wrap-select">
        <select class="selectpicker" title="Subcategory" name="sub_cat">
        </select>
        <img class="img-select" src="{{ asset("vendor/buyer/Img/arrow-black.svg") }}" alt="">
    </div>
</div>
<div class="col-3">
    <div class="wrap-select">
        <select class="selectpicker" title="Rating" name="rating">
            <option value="5">5 Stars</option>
            <option value="4">4 Stars &Up</option>
            <option value="3">3 Stars &Up</option>
            <option value="2">2 Stars &Up</option>
            <option value="1">1 Star &Up</option>
        </select>
        <img class="img-select" src="{{ asset("vendor/buyer/Img/arrow-black.svg") }}" alt="">
    </div>
</div>
<div class="col-3">
    <button class="btn-customer secondary btn" type="submit">Filter</button>
</div>
</form>
<script>
    $(document).ready(function() {
        $("#getProducts").submit(function(event){
            event.preventDefault(); //prevent default action
            var get_url = $(this).attr("action"); //get form action url
            var sub_cat = $('select[name="sub_cat"]').val() ? $('select[name="sub_cat"]').val() : 0;
            var rating = $('select[name="rating"]').val() ? $('select[name="rating"]').val() : 0;
            var url = get_url + '/' + $('select[name="cat"]').val() + '/' + sub_cat + '/' + rating;
            window.location.replace(url);
        });
    });
</script>