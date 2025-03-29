import GalleryInitialLoadImagesResponse from '../types/GalleryInitialLoadImagesResponse';
import GalleryImagesManipulator from '../components/GalleryImagesManipulator';
import ContainerAnimationInitializer from '../components/ContainerAnimationInitializer';

export default class GalleryImagesByNoFilterLoader {
    static readonly URL: string = '/api/v1/gallery/images?counter=0';
    static readonly METHOD: string = 'GET';

    private readonly loadingIndicator: HTMLElement | null;
    private readonly gifFilterButton: HTMLAnchorElement | null;
    private readonly imageFilterButton: HTMLAnchorElement | null;

    /**
     * @exception Error
     */
    constructor(
        private readonly galleryImagesManipulator: GalleryImagesManipulator,
        private readonly containerAnimationInitializer: ContainerAnimationInitializer,
        loadingIndicatorClass: string,
        gifFilterButtonId: string,
        imageFilterButtonId: string
    ) {
        this.loadingIndicator = document.querySelector(loadingIndicatorClass);
        this.gifFilterButton = document.getElementById(gifFilterButtonId) as HTMLAnchorElement | null;
        this.imageFilterButton = document.getElementById(imageFilterButtonId) as HTMLAnchorElement | null;
        if (this.loadingIndicator === null ||
            this.imageFilterButton === null ||
            this.gifFilterButton === null
        ) {
            throw new Error('Gallery images with no filter are not loaded');
        }
    }

    public load(): void {
        this.disableFilterButtons();
        this.displayLoadingIndicator();
        let ajaxHttpClient: XMLHttpRequest = new XMLHttpRequest();
        ajaxHttpClient.open(GalleryImagesByNoFilterLoader.METHOD, GalleryImagesByNoFilterLoader.URL, true);
        ajaxHttpClient.onreadystatechange = (): void => {
            if (ajaxHttpClient.readyState === 4 && ajaxHttpClient.status === 200) {
                const jsonResponse: GalleryInitialLoadImagesResponse = JSON.parse(ajaxHttpClient.response);
                this.galleryImagesManipulator.displayImagesInGallery(jsonResponse.urls);
                this.hideLoadingIndicator();
                this.enableFilterButtons();
                this.containerAnimationInitializer.init();
                document.dispatchEvent(new Event('resetFilter'));
            }
        };

        ajaxHttpClient.send();
    }

    private displayLoadingIndicator(): void {
        (this.loadingIndicator as HTMLElement).style.display = 'flex';
    }

    private hideLoadingIndicator(): void {
        (this.loadingIndicator as HTMLElement).style.display = 'none';
    }

    private disableFilterButtons(): void {
        (this.imageFilterButton as HTMLAnchorElement).classList.remove('xing-media-filter-button', 'xing-media-filter-button-selected');
        (this.imageFilterButton as HTMLAnchorElement).classList.add('xing-media-filter-button-disabled');
        (this.gifFilterButton as HTMLAnchorElement).classList.remove('xing-media-filter-button-selected', 'xing-media-filter-button');
        (this.gifFilterButton as HTMLAnchorElement).classList.add('xing-media-filter-button-disabled');
    }

    private enableFilterButtons(): void {
        (this.imageFilterButton as HTMLAnchorElement).classList.remove('xing-media-filter-button-disabled');
        (this.imageFilterButton as HTMLAnchorElement).classList.add('xing-media-filter-button');
        (this.gifFilterButton as HTMLAnchorElement).classList.remove('xing-media-filter-button-disabled');
        (this.gifFilterButton as HTMLAnchorElement).classList.add('xing-media-filter-button');
    }
}
