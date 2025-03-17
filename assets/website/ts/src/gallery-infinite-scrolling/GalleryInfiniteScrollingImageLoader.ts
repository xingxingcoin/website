import GalleryImagesByImageFilterLoader from '../gallery-filter/GalleryImagesByImageFilterLoader';
import GalleryImagesByGifFilterLoader from '../gallery-filter/GalleryImagesByGifFilterLoader';
import GalleryInitialLoadImagesResponse from '../types/GalleryInitialLoadImagesResponse';
import GalleryImagesManipulator from '../components/GalleryImagesManipulator';

export default class GalleryInfiniteScrollingImageLoader {
    static readonly URL: string = '/api/v1/gallery/images?counter=';
    private urlForRequest: string;
    static readonly METHOD: string = 'GET';
    private imageCounter: number;
    private isLoading: boolean;
    private imageFilterButton: HTMLElement;
    private gifFilterButton: HTMLElement;
    private footer: HTMLElement;
    private galleryImagesManipulator: GalleryImagesManipulator;

    constructor() {
        this.imageCounter = 1;
        this.imageFilterButton = document.getElementById('xing-media-images-filter-button');
        this.gifFilterButton = document.getElementById('xing-media-gifs-filter-button');
        this.footer = document.querySelector('footer');
        this.galleryImagesManipulator = new GalleryImagesManipulator();
        this.initEventListener();
    }

    private initEventListener(): void {
        document.addEventListener('DOMContentLoaded', (): void => {
            window.addEventListener('scroll', (): void => {
                if (this.isLoading) {
                    return;
                }

                const footerPosition: number = this.footer.getBoundingClientRect().top;
                const windowHeight: number = window.innerHeight;
                if (footerPosition < windowHeight + 50) {
                    this.loadImages();
                }
            });
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

    private loadImages(): void {
        this.isLoading = true;
        let ajaxHttpClient: XMLHttpRequest = new XMLHttpRequest();
        ajaxHttpClient.open(GalleryInfiniteScrollingImageLoader.METHOD, this.urlForRequest + this.imageCounter, true);
        ajaxHttpClient.onreadystatechange = (): void => {
            if (ajaxHttpClient.readyState === 4) {
                if (ajaxHttpClient.status === 200) {
                    const jsonResponse: GalleryInitialLoadImagesResponse = JSON.parse(ajaxHttpClient.response);
                    this.galleryImagesManipulator.displayImagesInGallery(jsonResponse.urls);
                    if (jsonResponse.urls.length > 0) {
                        this.imageCounter++;
                    }
                }
                this.isLoading = false;
            }
        };
        ajaxHttpClient.send();
    }
}
