import GalleryInitialLoadImagesResponse from '../types/GalleryInitialLoadImagesResponse';
import GalleryImagesManipulator from '../components/GalleryImagesManipulator';
import ContainerAnimationInitializer from '../components/ContainerAnimationInitializer';

export default class GalleryImagesByGifFilterLoader {
    static readonly URL: string = '/api/v1/gallery/images/filter?filter=gif&counter=';
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
        imageFilterButtonId: string,
    ) {
        this.loadingIndicator = document.querySelector(loadingIndicatorClass);
        this.gifFilterButton = document.getElementById(
            gifFilterButtonId,
        ) as HTMLAnchorElement | null;
        this.imageFilterButton = document.getElementById(
            imageFilterButtonId,
        ) as HTMLAnchorElement | null;
        if (
            this.loadingIndicator === null ||
            this.gifFilterButton === null ||
            this.imageFilterButton === null
        ) {
            throw new Error('Gallery images by gif filter are not loaded.');
        }
    }

    public load(): void {
        this.disableFilterButtons();
        this.displayLoadingIndicator();
        let ajaxHttpClient: XMLHttpRequest = new XMLHttpRequest();
        ajaxHttpClient.open(
            GalleryImagesByGifFilterLoader.METHOD,
            GalleryImagesByGifFilterLoader.URL + 0,
            true,
        );
        ajaxHttpClient.onreadystatechange = (): void => {
            if (ajaxHttpClient.readyState === 4 && ajaxHttpClient.status === 200) {
                const jsonResponse: GalleryInitialLoadImagesResponse = JSON.parse(
                    ajaxHttpClient.response,
                );
                this.galleryImagesManipulator.displayImagesInGallery(jsonResponse.urls);
                this.hideLoadingIndicator();
                this.enableFilterButtonsWithSelectedGifButton();
                this.containerAnimationInitializer.init();
                const event = new Event('afterGifFilterButtonCLicked');
                (this.gifFilterButton as HTMLAnchorElement).dispatchEvent(event);
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
        (this.imageFilterButton as HTMLAnchorElement).classList.remove(
            'xing-media-filter-button',
            'xing-media-filter-button-selected',
        );
        (this.imageFilterButton as HTMLAnchorElement).classList.add(
            'xing-media-filter-button-disabled',
        );
        (this.gifFilterButton as HTMLAnchorElement).classList.remove(
            'xing-media-filter-button-selected',
            'xing-media-filter-button',
        );
        (this.gifFilterButton as HTMLAnchorElement).classList.add(
            'xing-media-filter-button-disabled',
        );
    }

    private enableFilterButtonsWithSelectedGifButton(): void {
        (this.imageFilterButton as HTMLAnchorElement).classList.remove(
            'xing-media-filter-button-disabled',
        );
        (this.imageFilterButton as HTMLAnchorElement).classList.add('xing-media-filter-button');
        (this.gifFilterButton as HTMLAnchorElement).classList.remove(
            'xing-media-filter-button-disabled',
        );
        (this.gifFilterButton as HTMLAnchorElement).classList.add(
            'xing-media-filter-button-selected',
        );
    }
}
