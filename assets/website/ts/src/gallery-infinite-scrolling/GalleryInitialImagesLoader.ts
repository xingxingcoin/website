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

    constructor() {
        this.loadingIndicator = document.querySelector('.lds-dual-ring');
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
        let galleryContainer = document.querySelector('.xing-media-container');
        jsonResponse.forEach((mediaUrl: MediaUrl): void => {
            const anchor: HTMLAnchorElement = document.createElement('a');
            anchor.href = mediaUrl.imageViewerUrl;

            const div: HTMLDivElement = document.createElement('div');
            div.classList.add('xing-image-container');

            const img: HTMLImageElement = document.createElement('img');
            img.src = mediaUrl.mediaUrl;
            img.alt = 'Image of Xing';
            img.style.width = '200px';
            img.style.height = '200px';

            div.appendChild(img);
            anchor.appendChild(div);
            galleryContainer.appendChild(anchor);

            this.hideLoadingIndicator();
        });
    }

    private displayLoadingIndicator(): void {
        this.loadingIndicator.style.display = 'flex';
    }

    private hideLoadingIndicator(): void {
        this.loadingIndicator.style.display = 'none';
    }
}
