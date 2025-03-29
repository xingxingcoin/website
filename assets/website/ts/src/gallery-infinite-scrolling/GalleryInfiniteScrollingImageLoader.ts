import GalleryImagesByImageFilterLoader from '../gallery-filter/GalleryImagesByImageFilterLoader';
import GalleryImagesByGifFilterLoader from '../gallery-filter/GalleryImagesByGifFilterLoader';
import GalleryInitialLoadImagesResponse from '../types/GalleryInitialLoadImagesResponse';
import GalleryImagesManipulator from '../components/GalleryImagesManipulator';
import ContainerAnimationInitializer from '../components/ContainerAnimationInitializer';

export default class GalleryInfiniteScrollingImageLoader {
    static readonly URL: string = '/api/v1/gallery/images?counter=';
    private urlForRequest: string;
    static readonly METHOD: string = 'GET';
    private imageCounter: number;
    private isLoading: boolean;
    private readonly imageFilterButton: HTMLAnchorElement | null;
    private readonly gifFilterButton: HTMLAnchorElement | null;
    private readonly footer: HTMLElement | null;

    /**
     * @exception Error
     */
    constructor(
        private readonly galleryImagesManipulator: GalleryImagesManipulator,
        private readonly containerAnimationInitializer: ContainerAnimationInitializer,
        imageFilterButtonId: string,
        gifFilterButtonId: string,
        footerTag: string
    ) {
        this.imageCounter = 1;
        this.isLoading = false;
        this.urlForRequest = '';
        this.imageFilterButton = document.getElementById(imageFilterButtonId) as HTMLAnchorElement | null;
        this.gifFilterButton = document.getElementById(gifFilterButtonId) as HTMLAnchorElement | null;
        this.footer = document.querySelector(footerTag);
        if (this.imageFilterButton === null ||
            this.gifFilterButton === null ||
            this.footer === null
        ) {
            throw new Error('Gallery infinite scrolling images are not loaded.');
        }

        this.initEventListener();
    }

    private initEventListener(): void {
        document.addEventListener('DOMContentLoaded', (): void => {
            window.addEventListener('scroll', (): void => {
                if (this.isLoading) {
                    return;
                }

                const footerPosition: number = (this.footer as HTMLElement).getBoundingClientRect().top;
                const windowHeight: number = window.innerHeight;
                if (footerPosition < windowHeight + 50) {
                    this.loadImages();
                }
            });
        });
        (this.imageFilterButton as HTMLElement).addEventListener('afterImageFilterButtonCLicked', (): void => {
            this.imageCounter = 1;
            this.urlForRequest = GalleryInfiniteScrollingImageLoader.URL;
            if ((this.imageFilterButton as HTMLElement).classList.contains('xing-media-filter-button-selected')) {
                this.urlForRequest = GalleryImagesByImageFilterLoader.URL;
            }
        });
        this.urlForRequest = GalleryInfiniteScrollingImageLoader.URL;
        (this.gifFilterButton as HTMLElement).addEventListener('afterGifFilterButtonCLicked', (): void => {
            this.imageCounter = 1;
            if ((this.gifFilterButton as HTMLElement).classList.contains('xing-media-filter-button-selected')) {
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
            if (ajaxHttpClient.readyState === 4 && ajaxHttpClient.status === 200) {
                const jsonResponse: GalleryInitialLoadImagesResponse = JSON.parse(ajaxHttpClient.response);
                this.galleryImagesManipulator.displayImagesInGallery(jsonResponse.urls);
                if (jsonResponse.urls.length > 0) {
                    this.imageCounter++;
                }
                this.containerAnimationInitializer.init();
                this.isLoading = false;
            }
        };
        ajaxHttpClient.send();
    }
}
