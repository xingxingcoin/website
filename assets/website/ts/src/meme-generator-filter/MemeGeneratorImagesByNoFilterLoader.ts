import GalleryInitialLoadImagesResponse from '../types/GalleryInitialLoadImagesResponse';
import GalleryImagesManipulator from '../components/GalleryImagesManipulator';
import ContainerAnimationInitializer from '../components/ContainerAnimationInitializer';

export default class MemeGeneratorImagesByNoFilterLoader {
    static readonly URL: string = '/api/v1/meme-generator/images?counter=0';
    static readonly METHOD: string = 'GET';

    private readonly loadingIndicator: HTMLElement | null;
    private readonly memeImageFilterButton: HTMLAnchorElement | null;
    private readonly memeTemplateFilterButton: HTMLAnchorElement | null;

    /**
     * @exception Error
     */
    constructor(
        private readonly galleryImagesManipulator: GalleryImagesManipulator,
        private readonly containerAnimationInitializer: ContainerAnimationInitializer,
        loadingIndicatorClass: string,
        memeImageFilterButtonId: string,
        memeTemplateFilterButtonId: string
    ) {
        this.loadingIndicator = document.querySelector(loadingIndicatorClass);
        this.memeImageFilterButton = document.getElementById(memeImageFilterButtonId) as HTMLAnchorElement | null;
        this.memeTemplateFilterButton = document.getElementById(memeTemplateFilterButtonId) as HTMLAnchorElement | null;
        if (this.loadingIndicator === null ||
            this.memeTemplateFilterButton === null ||
            this.memeImageFilterButton === null
        ) {
            throw new Error('Meme generator images with no filter are not loaded.');
        }
    }

    public load(): void {
        this.disableFilterButtons();
        this.displayLoadingIndicator();
        let ajaxHttpClient: XMLHttpRequest = new XMLHttpRequest();
        ajaxHttpClient.open(MemeGeneratorImagesByNoFilterLoader.METHOD, MemeGeneratorImagesByNoFilterLoader.URL, true);
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
        (this.memeTemplateFilterButton as HTMLAnchorElement).classList.remove('xing-media-filter-button', 'xing-media-filter-button-selected');
        (this.memeTemplateFilterButton as HTMLAnchorElement).classList.add('xing-media-filter-button-disabled');
        (this.memeImageFilterButton as HTMLAnchorElement).classList.remove('xing-media-filter-button-selected', 'xing-media-filter-button');
        (this.memeImageFilterButton as HTMLAnchorElement).classList.add('xing-media-filter-button-disabled');
    }

    private enableFilterButtons(): void {
        (this.memeTemplateFilterButton as HTMLAnchorElement).classList.remove('xing-media-filter-button-disabled');
        (this.memeTemplateFilterButton as HTMLAnchorElement).classList.add('xing-media-filter-button');
        (this.memeImageFilterButton as HTMLAnchorElement).classList.remove('xing-media-filter-button-disabled');
        (this.memeImageFilterButton as HTMLAnchorElement).classList.add('xing-media-filter-button');
    }
}
