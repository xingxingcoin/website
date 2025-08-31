export default class NavigationAudioPlayer {
    private readonly navigationAudioPlayerButton: HTMLButtonElement | null;

    /**
     * @exception Error
     */
    constructor(navigationAudioPlayerButtonClass: string) {
        this.navigationAudioPlayerButton = document.querySelector(navigationAudioPlayerButtonClass);
        if (this.navigationAudioPlayerButton === null) {
            throw new Error('Navigation audio player not found.');
        }

        this.initEventListener();
    }

    private initEventListener(): void {
        (this.navigationAudioPlayerButton as HTMLButtonElement).addEventListener(
            'click',
            function (event: MouseEvent): void {
                event.preventDefault();
                let audioPlayButton: HTMLButtonElement = this;
                const audioPlayer = document.getElementById(
                    'navigation-audio-player',
                ) as HTMLAudioElement | null;
                if (audioPlayer === null) {
                    return;
                }
                if (audioPlayer.paused) {
                    audioPlayer.play();
                    audioPlayButton.innerHTML =
                        '<svg id="pauseIcon" width="24" height="24" viewBox="0 0 24 24" fill="black" xmlns="http://www.w3.org/2000/svg">\n' +
                        '<path d="M6 5h4v14H6zM14 5h4v14h-4z"/>\n' +
                        '</svg>';
                } else {
                    audioPlayer.pause();
                    audioPlayButton.innerHTML =
                        '<svg id="playIcon" width="24" height="24" viewBox="0 0 24 24" fill="black" xmlns="http://www.w3.org/2000/svg">\n' +
                        '<path d="M8 5v14l11-7z"/>\n' +
                        '</svg>';
                }
                audioPlayer.addEventListener('ended', function (): void {
                    audioPlayButton.innerHTML =
                        '<svg id="playIcon" width="24" height="24" viewBox="0 0 24 24" fill="black" xmlns="http://www.w3.org/2000/svg">\n' +
                        '<path d="M8 5v14l11-7z"/>\n' +
                        '</svg>';
                });
            },
        );
    }
}
