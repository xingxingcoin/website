import MediaUrl from '../types/MediaUrl';

export default class GalleryImagesManipulator {
    private galleryContainer: Element;

    constructor() {
        this.galleryContainer = document.querySelector('.xing-media-container');
    }

    public displayImagesInGallery(jsonResponse: MediaUrl[]): void
    {
        jsonResponse.forEach((mediaUrl: MediaUrl): void => {
            const anchor: HTMLAnchorElement = document.createElement('a');
            anchor.classList.add('container-bottom-hidden');
            anchor.href = mediaUrl.imageViewerUrl;

            const div: HTMLDivElement = document.createElement('div');
            div.classList.add('xing-image-container');

            const img: HTMLImageElement = document.createElement('img');
            img.src = mediaUrl.mediaUrl;
            img.alt = 'Image of Xing';

            div.appendChild(img);
            anchor.appendChild(div);
            this.galleryContainer.appendChild(anchor);
        });
    }
}
