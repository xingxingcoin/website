import GalleryInitialLoadImagesResponse from '../types/GalleryInitialLoadImagesResponse';
import GalleryImagesManipulator from '../components/GalleryImagesManipulator';
import ContainerAnimationInitializer from '../components/ContainerAnimationInitializer';

export default class GalleryInitialImagesLoader {
    static readonly URL: string = '/api/v1/gallery/images?counter=0';
    static readonly METHOD: string = 'GET';

    private loadingIndicator: HTMLElement;
    private filterButtons: NodeList;
    private galleryImagesManipulator: GalleryImagesManipulator;
    private containerAnimationInitializer: ContainerAnimationInitializer;

    constructor() {
        this.loadingIndicator = document.querySelector('.lds-dual-ring');
        this.filterButtons = document.querySelectorAll('.xing-media-filter-button-disabled');
        this.galleryImagesManipulator = new GalleryImagesManipulator();
        this.containerAnimationInitializer = new ContainerAnimationInitializer();
        this.initEventListener();
    }

    private initEventListener(): void
    {
        this.displayLoadingIndicator();
        document.addEventListener('DOMContentLoaded', (): void => {
            let ajaxHttpClient: XMLHttpRequest = new XMLHttpRequest();
            ajaxHttpClient.open(GalleryInitialImagesLoader.METHOD, GalleryInitialImagesLoader.URL, true);
            ajaxHttpClient.onreadystatechange = (): void => {
                if (ajaxHttpClient.readyState === 4 && ajaxHttpClient.status === 200) {
                    const jsonResponse: GalleryInitialLoadImagesResponse = JSON.parse(ajaxHttpClient.response);
                    this.galleryImagesManipulator.displayImagesInGallery(jsonResponse.urls);
                    this.hideLoadingIndicator();
                    this.enableFilterButtons();
                    this.containerAnimationInitializer.init();
                }
            };

            ajaxHttpClient.send();
        });
    }

    private displayLoadingIndicator(): void {
        this.loadingIndicator.style.display = 'flex';
    }

    private hideLoadingIndicator(): void {
        this.loadingIndicator.style.display = 'none';
    }

    private enableFilterButtons(): void {
        Array.from(this.filterButtons).forEach((filterButton: Element): void => {
            filterButton.classList.remove('xing-media-filter-button-disabled');
            filterButton.classList.add('xing-media-filter-button');
        });
    }
}
