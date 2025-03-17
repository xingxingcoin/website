import GalleryInitialLoadImagesResponse from '../types/GalleryInitialLoadImagesResponse';
import GalleryImagesManipulator from '../components/GalleryImagesManipulator';

export default class GalleryImagesByNoFilterLoader {
    static readonly URL: string = '/api/v1/gallery/images?counter=0';
    static readonly METHOD: string = 'GET';

    private loadingIndicator: HTMLElement;
    private gifFilterButton: HTMLElement;
    private imageFilterButton: HTMLElement;
    private galleryImagesManipulator: GalleryImagesManipulator;

    constructor() {
        this.loadingIndicator = document.querySelector('.lds-dual-ring');
        this.gifFilterButton = document.getElementById('xing-media-gifs-filter-button');
        this.imageFilterButton = document.getElementById('xing-media-images-filter-button');
        this.galleryImagesManipulator = new GalleryImagesManipulator();
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
                const event = new Event('resetFilter');
                document.dispatchEvent(event);
            }
        };

        ajaxHttpClient.send();
    }

    private displayLoadingIndicator(): void {
        this.loadingIndicator.style.display = 'flex';
    }

    private hideLoadingIndicator(): void {
        this.loadingIndicator.style.display = 'none';
    }

    private disableFilterButtons(): void {
        this.imageFilterButton.classList.remove('xing-media-filter-button', 'xing-media-filter-button-selected');
        this.imageFilterButton.classList.add('xing-media-filter-button-disabled');
        this.gifFilterButton.classList.remove('xing-media-filter-button-selected', 'xing-media-filter-button');
        this.gifFilterButton.classList.add('xing-media-filter-button-disabled');
    }

    private enableFilterButtons(): void {
        this.imageFilterButton.classList.remove('xing-media-filter-button-disabled');
        this.imageFilterButton.classList.add('xing-media-filter-button');
        this.gifFilterButton.classList.remove('xing-media-filter-button-disabled');
        this.gifFilterButton.classList.add('xing-media-filter-button');
    }
}
