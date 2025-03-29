import MemeGeneratorImagesManipulator from './MemeGeneratorImagesManipulator';
import MemeGeneratorInitialLoadImagesResponse from './types/MemeGeneratorInitialLoadImagesResponse';
import ContainerAnimationInitializer from '../components/ContainerAnimationInitializer';

export default class MemeGeneratorInitialImagesLoader {
    static readonly URL: string = '/api/v1/meme-generator/images?counter=0';
    static readonly METHOD: string = 'GET';

    private readonly loadingIndicator: HTMLElement | null;

    /**
     * @exception Error
     */
    constructor(private readonly memeGeneratorImagesManipulator: MemeGeneratorImagesManipulator,
                private readonly containerAnimationInitializer: ContainerAnimationInitializer,
                loadingIndicatorClass: string) {
        this.loadingIndicator = document.querySelector(loadingIndicatorClass);
        if (this.loadingIndicator === null) {
            throw new Error('Meme generator initial images are not loaded.');
        }

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
                    this.containerAnimationInitializer.init();
                }
            };

            ajaxHttpClient.send();
        });
    }

    private hideLoadingIndicator(): void {
        (this.loadingIndicator as HTMLElement).style.display = 'none';
    }
}
