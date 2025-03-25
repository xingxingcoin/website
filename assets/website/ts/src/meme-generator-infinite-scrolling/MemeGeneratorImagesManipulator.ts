import MediaUrl from './types/MediaUrl';

export default class MemeGeneratorImagesManipulator {
    private memeGeneratorContainer: HTMLElement;

    constructor() {
        this.memeGeneratorContainer = document.querySelector('.xing-media-container');
    }

    public displayImagesInMemeGenerator(jsonResponse: MediaUrl[]): void {
        jsonResponse.forEach((mediaUrl: MediaUrl): void => {
            const anchor: HTMLAnchorElement = document.createElement('a');
            anchor.classList.add('container-left-hidden');
            anchor.href = mediaUrl.imageViewerUrl;

            const div: HTMLDivElement = document.createElement('div');
            div.classList.add('xing-image-container');

            const img: HTMLImageElement = document.createElement('img');
            img.src = mediaUrl.mediaUrl;
            img.alt = 'Image of Xing';

            div.appendChild(img);
            anchor.appendChild(div);
            this.memeGeneratorContainer.appendChild(anchor);
        });
    }
}
