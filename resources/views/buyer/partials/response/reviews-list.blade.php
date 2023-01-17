@foreach($reviews as $review)
    <li class="item-review">
        <div class="d-flex justify-content-between">
            <div class="left">
                <div class="star-peview d-flex">
                    <div class="star d-flex">
                        <?php
                        showStars($review->rating);
                        ?>
                    </div>
                    <p class="color-black">{{$review->user->name}}</p>
                </div>
                <div class="d-flex">
                    @if($review->images)
                    <img class="img-review mr-2" src="{{ asset($review->images) }}" onclick="showImageReview('{{ $review->id }}')">
                    @endif
                    <p class="color-gray comment">{{$review->comment}}</p>
                </div>
            </div>
            <div >
                <p class="color-gray">{{showDate($review->created_at)}}</p>
            </div>
        </div>
    </li>
                                            <div id="{{ $review->id }}" class="demo-img">
                                                <img class="d-block w-100" src="{{ asset($review->images) }}">
                                            </div>
    <hr>
@endforeach
<div class="d-flex justify-content-end">
    {!! $reviews->render() !!}
</div>
