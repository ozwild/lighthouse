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
                    videoId: '{{ $record->youtube_id }}',
                    events: {
                        'onReady': onPlayerReady,
                        'onStateChange': onPlayerStateChange
                    }
                });
            }

            function onPlayerReady() {
                @if($record->video_start)
                player.seekTo({{ $record->video_start }});
                @endif
            }

            function onPlayerStateChange(event) {
                if (event.data === YT.PlayerState.ENDED && shouldLoop) {

                    @if($record->video_start)

                    player.seekTo({{ $record->video_start }});

                    @else

                    player.seekTo(0);

                    @endif

                }
            }

            window.onYouTubeIframeAPIReady = onYouTubeIframeAPIReady;
            window.getVideoTimestamp = function () {
                return player.getCurrentTime();
            };
            window.shoudLoop = shouldLoop;

        })();
    </script>

@endpush