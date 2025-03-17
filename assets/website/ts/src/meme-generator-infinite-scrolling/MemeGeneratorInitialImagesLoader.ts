import MemeGeneratorImagesManipulator from './MemeGeneratorImagesManipulator';

interface MediaUrl {
    imageViewerUrl: string
    mediaUrl: string
}

interface MemeGeneratorInitialLoadImagesResponse {
    urls: MediaUrl[]
}

export default class MemeGeneratorInitialImagesLoader {
    static readonly URL: string = '/api/v1/meme-generator/images?counter=0';
    static readonly METHOD: string = 'GET';

    private loadingIndicator: HTMLElement;
    private memeGeneratorImagesManipulator: MemeGeneratorImagesManipulator;

    constructor() {
        this.loadingIndicator = document.querySelector('.lds-dual-ring');
        this.memeGeneratorImagesManipulator = new MemeGeneratorImagesManipulator();
        this.initEventListener();
    }

    private initEventListener(): void {
        document.addEventListener('DOMContentLoaded', (): void => {
            let ajaxHttpClient: XMLHttpRequest = new XMLHttpRequest();
            ajaxHttpClient.open(MemeGeneratorInitialImagesLoader.METHOD, MemeGeneratorInitialImagesLoader.URL, true);
            ajaxHttpClient.onreadystatechange = (): void => {
                if (ajaxHttpClient.readyState === 4 && ajaxHttpClient.status === 200) {
                    const jsonResponse: MemeGeneratorInitialLoadImagesResponse = JSON.parse(ajaxHttpClient.response);
                    this.memeGeneratorImagesManipulator.displayImagesInMemeGenerator(jsonResponse.urls);
                    this.hideLoadingIndicator();
                }
            };

            ajaxHttpClient.send();
        });
    }

    private hideLoadingIndicator(): void {
        this.loadingIndicator.style.display = 'none';
    }
}
