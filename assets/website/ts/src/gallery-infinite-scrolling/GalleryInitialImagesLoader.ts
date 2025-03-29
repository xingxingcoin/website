import GalleryInitialLoadImagesResponse from '../types/GalleryInitialLoadImagesResponse';
import GalleryImagesManipulator from '../components/GalleryImagesManipulator';
import ContainerAnimationInitializer from '../components/ContainerAnimationInitializer';

export default class GalleryInitialImagesLoader {
    static readonly URL: string = '/api/v1/gallery/images?counter=0';
    static readonly METHOD: string = 'GET';

    private readonly loadingIndicator: HTMLDivElement | null;
    private readonly filterButtons: NodeList;

    /**
     * @exception Error
     */
    constructor(
        private readonly galleryImagesManipulator: GalleryImagesManipulator,
        private readonly containerAnimationInitializer: ContainerAnimationInitializer,
        loadingIndicatorClass: string,
        filterButtonsClass: string
    ) {
        this.loadingIndicator = document.querySelector(loadingIndicatorClass);
        this.filterButtons = document.querySelectorAll(filterButtonsClass);
        if (this.loadingIndicator === null || this.filterButtons.length === 0) {
            throw new Error('Gallery initial images are not loaded.');
        }

        this.initEventListener();
    }

    private initEventListener(): void {
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
        (this.loadingIndicator as HTMLDivElement).style.display = 'flex';
    }

    private hideLoadingIndicator(): void {
        (this.loadingIndicator as HTMLDivElement).style.display = 'none';
    }

    private enableFilterButtons(): void {
        Array.from(this.filterButtons).forEach((filterButton: any): void => {
            filterButton.classList.remove('xing-media-filter-button-disabled');
            filterButton.classList.add('xing-media-filter-button');
        });
    }
}
