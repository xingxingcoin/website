import MemeGeneratorImagesManipulator from './MemeGeneratorImagesManipulator';
import MemeGeneratorInitialLoadImagesResponse from './types/MemeGeneratorInitialLoadImagesResponse';
import ContainerAnimationInitializer from '../components/ContainerAnimationInitializer';

export default class MemeGeneratorInfiniteScrollingImageLoader {
    static readonly URL: string = '/api/v1/meme-generator/images?counter=';
    static readonly METHOD: string = 'GET';

    private imageCounter: number;
    private isLoading: boolean;
    private memeGeneratorImagesManipulator: MemeGeneratorImagesManipulator;
    private containerAnimationInitializer: ContainerAnimationInitializer;

    constructor() {
        this.imageCounter = 1;
        this.memeGeneratorImagesManipulator = new MemeGeneratorImagesManipulator();
        this.containerAnimationInitializer = new ContainerAnimationInitializer();
        this.initEventListener();
    }

    private initEventListener(): void {
        document.addEventListener('DOMContentLoaded', (): void => {
            window.addEventListener('scroll', (): void => {
                const footer: HTMLElement = document.querySelector('footer');
                if (!footer || this.isLoading) return;

                const footerPosition: number = footer.getBoundingClientRect().top;
                const windowHeight: number = window.innerHeight;

                if (footerPosition < windowHeight + 50) {
                    this.loadImages();
                }
            });
        });
    }

    private loadImages(): void {
        this.isLoading = true;
        let ajaxHttpClient: XMLHttpRequest = new XMLHttpRequest();
        ajaxHttpClient.open(MemeGeneratorInfiniteScrollingImageLoader.METHOD, MemeGeneratorInfiniteScrollingImageLoader.URL + this.imageCounter, true);
        ajaxHttpClient.onreadystatechange = (): void => {
            if (ajaxHttpClient.readyState === 4) {
                if (ajaxHttpClient.status === 200) {
                    const jsonResponse: MemeGeneratorInitialLoadImagesResponse = JSON.parse(ajaxHttpClient.response);
                    this.memeGeneratorImagesManipulator.displayImagesInMemeGenerator(jsonResponse.urls);
                    this.containerAnimationInitializer.init();
                    if (jsonResponse.urls.length > 0) {
                        this.imageCounter++;
                    }
                }
                this.isLoading = false;
            }
        };
        ajaxHttpClient.send();
    }
}
