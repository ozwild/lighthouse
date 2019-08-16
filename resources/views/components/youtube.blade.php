@push('scripts')
    <script>
        (function () {

            var player;
            var shouldLoop = true;
            var tag = document.createElement('script');
            tag.src = "https://www.youtube.com/iframe_api";
            var firstScriptTag = document.getElementsByTagName('script')[0];
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

            function onYouTubeIframeAPIReady() {
                player = new YT.Player('player', {
                    width: '426',
                    height: '240',
                    videoId: '{{ $record->video }}',
                    events: {
                        'onReady': onPlayerReady,
                        'onStateChange': onPlayerStateChange
                    }
                });
            }

            function onPlayerReady(event) {
                player.seekTo(9);
            }

            function onPlayerStateChange(event) {
                if (event.data === YT.PlayerState.ENDED && shouldLoop) {
                    player.seekTo(9);
                }
            }

            function stopVideo() {
                player.stopVideo();
            }

            window.onYouTubeIframeAPIReady = onYouTubeIframeAPIReady;
            window.getVideoTimestamp = function () {
                return player.getCurrentTime();
                return videoTarget.getCurrentTime();
            };
            window.shoudLoop = shouldLoop;

        })();
    </script>

@endpush