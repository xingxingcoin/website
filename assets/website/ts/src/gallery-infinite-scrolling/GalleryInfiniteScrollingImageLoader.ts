interface MediaUrl {
    imageViewerUrl: string
    mediaUrl: string
}

interface GalleryInitialLoadImagesResponse {
    urls: MediaUrl[]
}

export default class GalleryInfiniteScrollingImageLoader {
    static readonly URL: string = '/api/v1/gallery/images?counter=';
    static readonly METHOD: string = 'GET';
    private imageCounter: number;
    private isLoading: boolean;

    constructor() {
        this.imageCounter = 1;
        this.initEventListener();
    }

    private initEventListener(): void {
        document.addEventListener('DOMContentLoaded', (): void => {
            window.addEventListener('scroll', (): void => this.onScroll());
        });
    }

    private onScroll() {
        const footer: HTMLElement = document.querySelector('footer');
        if (!footer || this.isLoading) return;

        const footerPosition = footer.getBoundingClientRect().top;
        const windowHeight = window.innerHeight;

        if (footerPosition < windowHeight + 50) {
            this.loadImages();
        }
    }
    private loadImages(): void
    {
        this.isLoading = true;

        let ajaxHttpClient: XMLHttpRequest = new XMLHttpRequest();
        ajaxHttpClient.open(GalleryInfiniteScrollingImageLoader.METHOD, GalleryInfiniteScrollingImageLoader.URL + this.imageCounter, true);
        ajaxHttpClient.onreadystatechange = (): void => {
            if (ajaxHttpClient.readyState === 4) {
                if (ajaxHttpClient.status === 200) {
                    const jsonResponse: GalleryInitialLoadImagesResponse = JSON.parse(ajaxHttpClient.response);
                    this.displayImagesInGallery(jsonResponse.urls);
                    if (jsonResponse.urls.length > 0) {
                        this.imageCounter++;
                    }
                }
                this.isLoading = false;
            }
        };
        ajaxHttpClient.send();
    }
    private displayImagesInGallery(jsonResponse: MediaUrl[]): void
    {
        let galleryContainer = document.querySelector('.xing-media-container');
        jsonResponse.forEach((mediaUrl: MediaUrl): void => {
            const anchor: HTMLAnchorElement = document.createElement('a');
            anchor.href = mediaUrl.imageViewerUrl;

            const div: HTMLDivElement = document.createElement('div');
            div.classList.add('xing-image-container');

            const img: HTMLImageElement = document.createElement('img');
            img.src = mediaUrl.mediaUrl;
            img.alt = 'Image of Xing';
            img.style.width = '200px';
            img.style.height = '200px';

            div.appendChild(img);
            anchor.appendChild(div);
            galleryContainer.appendChild(anchor);
        });
    }
}
