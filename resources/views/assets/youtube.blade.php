@push('scripts')
    <script>
        (function () {

            let tag = document.createElement('script');
            tag.src = "https://www.youtube.com/iframe_api";
            let firstScriptTag = document.getElementsByTagName('script')[0];
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

            function onYouTubeIframeAPIReady() {
                let event = document.createEvent('Event');
                event.initEvent('youtube.ready', true, true);
                document.dispatchEvent(event);
            }

            window.onYouTubeIframeAPIReady = onYouTubeIframeAPIReady;

        })();
    </script>

@endpush