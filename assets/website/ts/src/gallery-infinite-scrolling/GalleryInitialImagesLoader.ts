interface MediaUrl {
    imageViewerUrl: string
    mediaUrl: string
}

interface GalleryInitialLoadImagesResponse {
    urls: MediaUrl[]
}

export default class GalleryInitialImagesLoader {
    static readonly URL: string = '/api/v1/gallery/images?counter=0';
    static readonly METHOD: string = 'GET';

    private loadingIndicator: HTMLElement;
    private filterButtons: NodeList;
    private galleryContainer: Element;

    constructor() {
        this.loadingIndicator = document.querySelector('.lds-dual-ring');
        this.filterButtons = document.querySelectorAll('.xing-media-filter-button-disabled');
        this.galleryContainer = document.querySelector('.xing-media-container');
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
                    this.displayImagesInGallery(jsonResponse.urls);
                }
            };

            ajaxHttpClient.send();
        });
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
            this.enableFilterButtons();
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
