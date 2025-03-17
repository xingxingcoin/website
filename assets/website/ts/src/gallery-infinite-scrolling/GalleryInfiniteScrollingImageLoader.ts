import GalleryImagesByImageFilterLoader from '../gallery-filter/GalleryImagesByImageFilterLoader';
import GalleryImagesByGifFilterLoader from '../gallery-filter/GalleryImagesByGifFilterLoader';

interface MediaUrl {
    imageViewerUrl: string
    mediaUrl: string
}

interface GalleryInitialLoadImagesResponse {
    urls: MediaUrl[]
}

export default class GalleryInfiniteScrollingImageLoader {
    static readonly URL: string = '/api/v1/gallery/images?counter=';
    private urlForRequest: string;
    static readonly METHOD: string = 'GET';
    private imageCounter: number;
    private isLoading: boolean;
    private imageFilterButton: HTMLElement;
    private gifFilterButton: HTMLElement;
    private galleryContainer: Element;

    constructor() {
        this.imageCounter = 1;
        this.imageFilterButton = document.getElementById('xing-media-images-filter-button');
        this.gifFilterButton = document.getElementById('xing-media-gifs-filter-button');
        this.galleryContainer = document.querySelector('.xing-media-container');
        this.initEventListener();
    }

    private initEventListener(): void {
        document.addEventListener('DOMContentLoaded', (): void => {
            window.addEventListener('scroll', (): void => this.onScroll());
        });
        this.imageFilterButton.addEventListener('afterImageFilterButtonCLicked', (): void => {
            this.imageCounter = 1;
            this.urlForRequest = GalleryInfiniteScrollingImageLoader.URL;
            if (this.imageFilterButton.classList.contains('xing-media-filter-button-selected')) {
                this.urlForRequest = GalleryImagesByImageFilterLoader.URL;
            }
        });
        this.urlForRequest = GalleryInfiniteScrollingImageLoader.URL;
        this.gifFilterButton.addEventListener('afterGifFilterButtonCLicked', (): void => {
            this.imageCounter = 1;
            if (this.gifFilterButton.classList.contains('xing-media-filter-button-selected')) {
                this.urlForRequest = GalleryImagesByGifFilterLoader.URL;
            }
        });
        document.addEventListener('resetFilter', (): void => {
            this.imageCounter = 1;
            this.urlForRequest = GalleryInfiniteScrollingImageLoader.URL;
        });
    }

    private onScroll() {
        const footer: HTMLElement = document.querySelector('footer');
        if (!footer || this.isLoading) {
            return;
        }

        const footerPosition: number = footer.getBoundingClientRect().top;
        const windowHeight: number = window.innerHeight;

        if (footerPosition < windowHeight + 50) {
            this.loadImages();
        }
    }
    private loadImages(): void
    {
        this.isLoading = true;

        let ajaxHttpClient: XMLHttpRequest = new XMLHttpRequest();
        ajaxHttpClient.open(GalleryInfiniteScrollingImageLoader.METHOD, this.urlForRequest + this.imageCounter, true);
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
        jsonResponse.forEach((mediaUrl: MediaUrl): void => {
            const anchor: HTMLAnchorElement = document.createElement('a');
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
