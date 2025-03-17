interface MediaUrl {
    imageViewerUrl: string
    mediaUrl: string
}

interface GalleryInitialLoadImagesResponse {
    urls: MediaUrl[]
}

export default class GalleryImagesByGifFilterLoader {
    static readonly URL: string = '/api/v1/gallery/images/filter?filter=gif&counter=';
    static readonly METHOD: string = 'GET';

    private loadingIndicator: HTMLElement;
    private galleryContainer: Element;
    private gifFilterButton: HTMLElement;
    private imageFilterButton: HTMLElement;

    constructor() {
        this.loadingIndicator = document.querySelector('.lds-dual-ring');
        this.galleryContainer = document.querySelector('.xing-media-container');
        this.gifFilterButton = document.getElementById('xing-media-gifs-filter-button');
        this.imageFilterButton = document.getElementById('xing-media-images-filter-button');
    }

    public load(): void {
        this.disableFilterButtons();
        this.displayLoadingIndicator();
        let ajaxHttpClient: XMLHttpRequest = new XMLHttpRequest();
        ajaxHttpClient.open(GalleryImagesByGifFilterLoader.METHOD, GalleryImagesByGifFilterLoader.URL + 0, true);
        ajaxHttpClient.onreadystatechange = (): void => {
            if (ajaxHttpClient.readyState === 4 && ajaxHttpClient.status === 200) {
                const jsonResponse: GalleryInitialLoadImagesResponse = JSON.parse(ajaxHttpClient.response);
                this.displayImagesInGallery(jsonResponse.urls);
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

            this.hideLoadingIndicator();
            this.enableFilterButtonsWithSelectedGifButton();
            const event = new Event('afterGifFilterButtonCLicked');
            this.gifFilterButton.dispatchEvent(event);
        });
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
    private enableFilterButtonsWithSelectedGifButton(): void {
        this.imageFilterButton.classList.remove('xing-media-filter-button-disabled');
        this.imageFilterButton.classList.add('xing-media-filter-button');
        this.gifFilterButton.classList.remove('xing-media-filter-button-disabled');
        this.gifFilterButton.classList.add('xing-media-filter-button-selected');
    }
}
