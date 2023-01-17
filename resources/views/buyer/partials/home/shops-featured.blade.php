@push('stylesheets')
    <style>
        .video_mask{
            position:absolute;
            z-index:25;
            opacity:0;
        }
        .background-shop-featured {
            background-color: rgb(48, 182, 164, 0.12);
            padding: 24px;
            border-radius: 12px;
            margin-left: 8px;
        }
        #moviesCarousel{
            width: 100%;
        }
        .store-info{
            padding-left: 36px;
            padding-right: 60px;
        }
        .carousel-indicators-video{
            bottom: -44px;
        }
    </style>
@endpush
<div id="moviesCarousel" class="web-block carousel slide" data-ride="carousel">
    <ol class="carousel-indicators carousel-indicators-video">
        @php
            $i = 0;
        @endphp
        @foreach($featureStores as $store)
            @isset($store->cover_video)
                <li data-target="#moviesCarousel"
                    data-slide-to="{{$i}}"
                    class="{{$i==0 ? 'active' : ''}}">
                </li>
                @php
                    $i++;
                @endphp
            @endif
        @endforeach
    </ol>
    <div class="carousel-inner">
        @php
            $i = 0;
        @endphp
        @foreach($featureStores as $store)
            @isset($store->cover_video)
                <div class="carousel-item {{$i==0 ? 'active' : ''}} background-shop-featured">
                    <div class="d-flex justify-content-between" style="margin-right: 8px">
                        <div class="w-100 align-self-center text-center store-info">
                            <img class="seller-home-img"
                                 src="{{getStoreAvatarUrl($store->avatar_image)}}"
                                 onerror="this.src='{{asset('img/store-avatar/default-avatar.png')}}'">
                            <p class="truncate-overflow-one shukshuk-dark-gray product-subtitle">{{$store->name}}</p>
                            <p class="mt-8px mb-8px">{{$store->description}}</p>
                            <a class="shukshuk-accent" href="{{route('store.index', $store->slug)}}">Visit Shop <img src="{{asset('vendor/buyer/Img/external-link.svg')}}"></a>
                        </div>
                        <div>
                            <iframe class="img-responsive" width="800" height="450" frameborder="0"
                                    id="yt-{{$i}}"
                                    style="margin-bottom: -4px"
                                    allowfullscreen="allowfullscreen"
                                    src="{{convertYoutube($store->cover_video)}}?enablejsapi=1">
                            </iframe>
                        </div>
                    </div>
                </div>
                @php
                $i++;
                @endphp
            @endisset
        @endforeach

    </div>
</div>

@push('scripts')
    <script>
        window.onpageshow = function(event) {
            if (event.persisted) {
                window.location.reload()
            }
        };
        $(document).ready(function()
        {
            $('#moviesCarousel').on('slide.bs.carousel', function(event) {
                // The variable "players" contain each Youtube Player for each iframe video
                // Reference: https://developers.google.com/youtube/iframe_api_reference#Loading_a_Video_Player
                // event.from - The index of the current video (before the slide occurs)
                //            - It is also the index of the corresponding player for the current video
                // Reference: https://getbootstrap.com/docs/4.4/components/carousel/#events
                players[event.from].pauseVideo();
            });
        });

        // Start of snippet from: https://developers.google.com/youtube/iframe_api_reference
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
        var players = []; // would contain 1 player for each iframe video
        function onYouTubeIframeAPIReady()
        {
            var allMovieIframes = document.getElementById("moviesCarousel").getElementsByTagName('iframe');
            for (currentIFrame of allMovieIframes)
            {
                players.push(new YT.Player(
                    currentIFrame.id, // the target iframe video, here it is  either katniss, rancho, or logan
                    { events: { 'onStateChange': onPlayerStateChange } }
                ));
            }
        }
        function onPlayerStateChange(event) // triggered everytime ANY iframe video player among the "players" list is played, paused, ended, etc.
        {
            // Check if any iframe video is being played (or is currently buffering to be played)
            // Reference: https://developers.google.com/youtube/iframe_api_reference#Events
            if (event.data == YT.PlayerState.PLAYING || event.data == YT.PlayerState.BUFFERING)
            {
                // If any player has been detected to be currently playing or buffering, pause the carousel from sliding
                // .carousel('pause') - Stops the carousel from cycling through items.
                // Reference: https://getbootstrap.com/docs/4.4/components/carousel/#methods
                $('#moviesCarousel').carousel('pause');
            }
            else
            {
                // If there are no currently playing nor buffering videos, resume the sliding of the carousel.
                // This means that once the current video is in a state that is not playing (aside from buffering), either it was:
                //     1. paused intentionally
                //     2. paused as an effect of a slide
                //     3. video has ended
                //     4. wasn't totally played from the start
                //     5. and literally any form where the video timer isn't running ;)
                //     - then the carousel would now resume sliding.
                $('#moviesCarousel').carousel();
            }
        }
    </script>
@endpush