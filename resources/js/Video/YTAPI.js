export default class YTAPILoader {

    static onYouTubeIframeAPIReady() {
        let event = document.createEvent('Event');
        event.initEvent('youtube.ready', true, true);
        document.dispatchEvent(event);
    }

    static load() {

        this.bootstrap();

        let tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        let firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        return new Promise(resolve => {
            document.addEventListener('youtube.ready', e => {
                resolve();
            });
        });
    }

    static bootstrap() {
        window.onYouTubeIframeAPIReady = this.onYouTubeIframeAPIReady;
    }

}